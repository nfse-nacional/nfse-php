<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Str;

/**
 * Gerador de DTOs baseado em schemas XSD versionados
 * 
 * Este script permite gerar DTOs para diferentes versões do schema NFSe
 * baseando-se nos arquivos XSD em references/schemas/vX.X.X/
 */
class XsdDtoGenerator
{
    private string $version;
    private string $versionNamespace;
    private string $schemaDir;
    private string $baseNamespace;
    private string $baseOutputDir;
    private array $complexTypes = [];
    private array $simpleTypes = [];
    private array $elements = [];
    
    public function __construct(string $version = '1.0.0')
    {
        $this->version = $version;
        // Converter versão para namespace válido (ex: 1.0.0 -> V1_0_0)
        $this->versionNamespace = 'V' . str_replace('.', '_', $version);
        $this->schemaDir = __DIR__ . "/../references/schemas/v{$version}";
        // Namespace base agora inclui a versão - usar NFSe (não Nfse)
        $this->baseNamespace = 'NFSe\\Dto\\' . $this->versionNamespace;
        $this->baseOutputDir = __DIR__ . "/../src/Dto/{$this->versionNamespace}";
        
        if (!is_dir($this->schemaDir)) {
            throw new Exception("Schema directory not found: {$this->schemaDir}");
        }
    }
    
    public function generate(): void
    {
        echo "Generating DTOs for NFSe Schema version {$this->version}...\n";
        
        // Limpar diretório de saída
        if (is_dir($this->baseOutputDir)) {
            $this->rrmdir($this->baseOutputDir);
        }
        mkdir($this->baseOutputDir, 0755, true);
        
        // Carregar todos os XSDs
        $this->loadSchemas();
        
        // Gerar classes para tipos complexos
        $this->generateComplexTypes();
        
        // Gerar classes principais (DPS, NFSe, Evento, etc)
        $this->generateRootElements();
        
        echo "DTOs generated successfully in {$this->baseOutputDir}\n";
        echo "Version: {$this->version}\n";
    }
    
    private function loadSchemas(): void
    {
        echo "Loading XSD schemas from {$this->schemaDir}...\n";
        
        $xsdFiles = glob($this->schemaDir . '/*.xsd');
        
        foreach ($xsdFiles as $xsdFile) {
            $filename = basename($xsdFile);
            echo "  - Loading {$filename}...\n";
            
            $xml = simplexml_load_file($xsdFile);
            if (!$xml) {
                echo "    Warning: Could not load {$filename}\n";
                continue;
            }
            
            // Registrar namespaces
            $xml->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
            
            // Extrair tipos complexos
            $complexTypes = $xml->xpath('//xs:complexType[@name]');
            foreach ($complexTypes as $type) {
                $name = (string)$type['name'];
                $this->complexTypes[$name] = $type;
            }
            
            // Extrair tipos simples
            $simpleTypes = $xml->xpath('//xs:simpleType[@name]');
            foreach ($simpleTypes as $type) {
                $name = (string)$type['name'];
                $this->simpleTypes[$name] = $type;
            }
            
            // Extrair elementos raiz
            $elements = $xml->xpath('//xs:element[@name]');
            foreach ($elements as $element) {
                $name = (string)$element['name'];
                $this->elements[$name] = $element;
            }
        }
        
        echo "Loaded " . count($this->complexTypes) . " complex types\n";
        echo "Loaded " . count($this->simpleTypes) . " simple types\n";
        echo "Loaded " . count($this->elements) . " root elements\n";
    }
    
    private function generateComplexTypes(): void
    {
        echo "\nGenerating complex type classes...\n";
        
        foreach ($this->complexTypes as $typeName => $typeNode) {
            $this->generateClassFromComplexType($typeName, $typeNode);
        }
    }
    
    private function generateRootElements(): void
    {
        echo "\nGenerating root element classes...\n";
        
        // Elementos principais que queremos gerar
        $mainElements = ['DPS', 'NFSe', 'evento', 'pedRegEvento'];
        
        foreach ($mainElements as $elementName) {
            if (isset($this->elements[$elementName])) {
                $this->generateClassFromElement($elementName, $this->elements[$elementName]);
            }
        }
    }
    
    private function generateClassFromComplexType(string $typeName, \SimpleXMLElement $typeNode): string
    {
        // Determinar namespace e diretório baseado na hierarquia XML
        $className = $this->getClassNameFromType($typeName);
        $namespace = $this->getNamespaceForType($typeName);
        $outputDir = $this->getOutputDirForNamespace($namespace);
        
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }
        
        // Extrair propriedades
        $properties = $this->extractProperties($typeNode);
        
        // Gerar conteúdo da classe
        $content = $this->generateClassContent($className, $namespace, $properties, $typeName);
        
        // Salvar arquivo
        $filePath = $outputDir . '/' . $className . '.php';
        file_put_contents($filePath, $content);
        
        return $namespace . '\\' . $className;
    }
    
    private function generateClassFromElement(string $elementName, \SimpleXMLElement $elementNode): string
    {
        $className = Str::studly($elementName) . 'Data';
        $namespace = $this->baseNamespace;
        $outputDir = $this->baseOutputDir;
        
        // Se o elemento tem um tipo, usar esse tipo
        if (isset($elementNode['type'])) {
            $typeName = $this->stripNamespace((string)$elementNode['type']);
            if (isset($this->complexTypes[$typeName])) {
                return $this->generateClassFromComplexType($typeName, $this->complexTypes[$typeName]);
            }
        }
        
        // Caso contrário, extrair propriedades inline
        $properties = $this->extractProperties($elementNode);
        
        $content = $this->generateClassContent($className, $namespace, $properties, $elementName);
        
        $filePath = $outputDir . '/' . $className . '.php';
        file_put_contents($filePath, $content);
        
        return $namespace . '\\' . $className;
    }
    
    private function extractProperties(\SimpleXMLElement $node): array
    {
        $properties = [];
        
        // Registrar namespace xs antes de usar xpath
        $node->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
        
        // Buscar elementos dentro de sequence, choice, all, etc
        $elements = $node->xpath('.//xs:element[@name]');
        
        if ($elements === false) {
            $elements = [];
        }
        
        foreach ($elements as $element) {
            // Registrar namespace para o elemento filho também
            $element->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
            
            $name = (string)$element['name'];
            $type = isset($element['type']) ? $this->stripNamespace((string)$element['type']) : 'string';
            $minOccurs = isset($element['minOccurs']) ? (int)$element['minOccurs'] : 1;
            $maxOccurs = isset($element['maxOccurs']) ? (string)$element['maxOccurs'] : '1';
            
            // Determinar se é opcional
            $isOptional = $minOccurs === 0;
            
            // Determinar se é array
            $isArray = $maxOccurs === 'unbounded' || (is_numeric($maxOccurs) && (int)$maxOccurs > 1);
            
            // Buscar documentação
            $documentation = '';
            $docNodes = $element->xpath('.//xs:documentation');
            if (!empty($docNodes)) {
                $documentation = trim((string)$docNodes[0]);
            }
            
            $properties[] = [
                'name' => $name,
                'type' => $type,
                'isOptional' => $isOptional,
                'isArray' => $isArray,
                'documentation' => $documentation,
            ];
        }
        
        // Buscar atributos
        $attributes = $node->xpath('.//xs:attribute[@name]');
        if ($attributes === false) {
            $attributes = [];
        }
        
        foreach ($attributes as $attribute) {
            $name = (string)$attribute['name'];
            $type = isset($attribute['type']) ? $this->stripNamespace((string)$attribute['type']) : 'string';
            $use = isset($attribute['use']) ? (string)$attribute['use'] : 'optional';
            
            $properties[] = [
                'name' => $name,
                'type' => $type,
                'isOptional' => $use !== 'required',
                'isArray' => false,
                'documentation' => 'Atributo XML',
                'isAttribute' => true,
            ];
        }
        
        return $properties;
    }
    
    private function generateClassContent(string $className, string $namespace, array $properties, string $originalName): string
    {
        $content = "<?php\n\n";
        $content .= "namespace {$namespace};\n\n";
        $content .= "/**\n";
        $content .= " * {$className}\n";
        $content .= " * \n";
        $content .= " * Gerado automaticamente do schema XSD versão {$this->version}\n";
        $content .= " * Tipo original: {$originalName}\n";
        $content .= " */\n";
        $content .= "class {$className} \n";
        $content .= "{\n";
        
        foreach ($properties as $prop) {
            $propName = $prop['name'];
            $phpType = $this->getPhpType($prop['type']);
            $isOptional = $prop['isOptional'];
            $isArray = $prop['isArray'];
            
            // Documentação
            if (!empty($prop['documentation'])) {
                $content .= "    /**\n";
                $docLines = explode("\n", wordwrap($prop['documentation'], 100));
                foreach ($docLines as $line) {
                    $content .= "     * " . trim($line) . "\n";
                }
                $content .= "     */\n";
            }
            
            // Tipo da propriedade
            if ($isArray) {
                $content .= "    public array \${$propName} = [];\n\n";
            } else {
                $nullMark = $isOptional ? '?' : '';
                $defaultValue = $isOptional ? ' = null' : '';
                $content .= "    public {$nullMark}{$phpType} \${$propName}{$defaultValue};\n\n";
            }
        }
        
        $content .= "}\n";
        
        return $content;
    }
    
    private function getClassNameFromType(string $typeName): string
    {
        // Remover prefixo 'T' se existir (convenção comum em XSD)
        if (str_starts_with($typeName, 'T')) {
            $typeName = substr($typeName, 1);
        }
        
        // Normalizar variações de case ANTES de converter para StudlyCase
        $typeName = str_replace('Nfse', 'NFSe', $typeName);
        $typeName = str_replace('nfse', 'NFSe', $typeName);
        
        $className = Str::studly($typeName);
        
        // Adicionar sufixo Data se não terminar com Dto ou Data
        if (!str_ends_with($className, 'Data') && !str_ends_with($className, 'Dto')) {
            $className .= 'Data';
        }
        
        return $className;
    }
    
    private function getNamespaceForType(string $typeName): string
    {
        // Remover prefixo 'TC' se existir
        $cleanName = $typeName;
        if (str_starts_with($cleanName, 'TC')) {
            $cleanName = substr($cleanName, 2);
        }
        
        // Normalizar variações de case (NFSe vs Nfse)
        $cleanName = str_replace('Nfse', 'NFSe', $cleanName);
        
        // Mapeamento hierárquico baseado na estrutura XML
        // NFSe -> InfNFSe -> DPS -> InfDPS -> ...
        
        $hierarchyMap = [
            // Raiz NFSe
            'NFSe' => '',
            'InfNFSe' => 'NFSe',
            
            // Dentro de infNFSe
            'Emitente' => 'NFSe\\InfNFSe',
            'Emit' => 'NFSe\\InfNFSe',
            'EnderecoEmitente' => 'NFSe\\InfNFSe\\Emit',
            'ValoresNFSe' => 'NFSe\\InfNFSe',
            'Valores' => 'NFSe\\InfNFSe',
            'DocOutNFSe' => 'NFSe\\InfNFSe',
            
            // DPS dentro de infNFSe
            'DPS' => 'NFSe\\InfNFSe',
            'InfDPS' => 'NFSe\\InfNFSe\\DPS',
            
            // Dentro de infDPS
            'Substituicao' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Subst' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'InfoPrestador' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Prestador' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Prest' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Tomador' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Toma' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Intermediario' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Interm' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Servico' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'Serv' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            
            // Endereços (genérico - pode ser de Prest, Toma, Interm)
            'Endereco' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'End' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'EnderecoNacional' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\End',
            'EndNac' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\End',
            'EnderecoExterior' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\End',
            'EndExt' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\End',
            
            // Regime Tributário
            'RegimeTributario' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            'RegTrib' => 'NFSe\\InfNFSe\\DPS\\InfDPS',
            
            // Serviço e subgrupos
            'LocalPrestacao' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'LocPrest' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'CodigoServico' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'CServ' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'ComercioExterior' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'ComExt' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'Obra' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'AtividadeEvento' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'AtvEvento' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'InformacaoComplementar' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            'InfoCompl' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Serv',
            
            // Valores do DPS (não confundir com Valores da NFSe)
            'ValorServicoPrestado' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'VServPrest' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'DescontoCondicionadoIncondicionado' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'VDescCondIncond' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'DeducaoReducao' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'VDedRed' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'Tributacao' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'Trib' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores',
            'TributacaoMunicipal' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores\\Trib',
            'TribMun' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores\\Trib',
            'TributacaoFederal' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores\\Trib',
            'TribFed' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores\\Trib',
            'TotalTributacao' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores\\Trib',
            'TotTrib' => 'NFSe\\InfNFSe\\DPS\\InfDPS\\Valores\\Trib',
            
            // Eventos
            'Evento' => '',
            'InfEvento' => 'Evento',
            'PedRegEvento' => '',
            'InfPedReg' => 'Evento\\PedRegEvento',
        ];
        
        // Buscar no mapa
        if (isset($hierarchyMap[$cleanName])) {
            $path = $hierarchyMap[$cleanName];
            return empty($path) ? $this->baseNamespace : $this->baseNamespace . '\\' . $path;
        }
        
        // Fallback: tentar detectar pela nomenclatura
        if (str_contains($cleanName, 'Evento')) {
            return $this->baseNamespace . '\\Evento';
        }
        
        if (str_contains($cleanName, 'DPS') || str_contains($cleanName, 'Dps')) {
            return $this->baseNamespace . '\\NFSe\\InfNFSe\\DPS';
        }
        
        if (str_contains($cleanName, 'NFSe')) {
            return $this->baseNamespace . '\\NFSe';
        }
        
        // Namespace padrão
        return $this->baseNamespace;
    }
    
    private function getOutputDirForNamespace(string $namespace): string
    {
        $relativePath = str_replace($this->baseNamespace . '\\', '', $namespace);
        $relativePath = str_replace('\\', '/', $relativePath);
        
        // Normalizar case para evitar duplicatas (Nfse -> NFSe)
        $relativePath = str_replace('/Nfse/', '/NFSe/', $relativePath);
        $relativePath = str_replace('/nfse/', '/NFSe/', $relativePath);
        
        return $this->baseOutputDir . '/' . $relativePath;
    }
    
    private function getPhpType(string $xsdType): string
    {
        // Mapear tipos XSD para tipos PHP
        $typeMap = [
            'string' => 'string',
            'int' => 'int',
            'integer' => 'int',
            'decimal' => 'string',
            'boolean' => 'bool',
            'date' => 'string',
            'dateTime' => 'string',
            'time' => 'string',
            'anyURI' => 'string',
            'base64Binary' => 'string',
        ];
        
        // Remover prefixo xs: se existir
        $xsdType = $this->stripNamespace($xsdType);
        
        // Se é um tipo complexo, retornar o nome da classe
        if (isset($this->complexTypes[$xsdType])) {
            return '\\' . $this->getNamespaceForType($xsdType) . '\\' . $this->getClassNameFromType($xsdType);
        }
        
        return $typeMap[$xsdType] ?? 'string';
    }
    
    private function stripNamespace(string $name): string
    {
        if (str_contains($name, ':')) {
            return substr($name, strpos($name, ':') + 1);
        }
        return $name;
    }
    
    private function rrmdir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object)) {
                    $this->rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        rmdir($dir);
    }
}

// Processar argumentos da linha de comando
$version = $argv[1] ?? '1.0.0';

try {
    $generator = new XsdDtoGenerator($version);
    $generator->generate();
    echo "\n✓ DTOs gerados com sucesso!\n";
} catch (Exception $e) {
    echo "\n✗ Erro: " . $e->getMessage() . "\n";
    exit(1);
}
