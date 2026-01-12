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
    private array $typeNamespaceMap = [];
    
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
        
        // Construir hierarquia automaticamente
        $this->buildHierarchy();
        
        // Gerar enums a partir de simpleTypes
        $this->generateEnums();
        
        // Gerar classes para tipos complexos
        $this->generateComplexTypes();
        
        // Gerar classes principais (DPS, NFSe, Evento, etc)
        $this->generateRootElements();
        
        echo "DTOs generated successfully in {$this->baseOutputDir}\n";
        echo "Version: {$this->version}\n";
    }

    private function buildHierarchy(): void
    {
        echo "Building type hierarchy...\n";

        // Ordem de preferência para definir a hierarquia.
        // NFSe é o root principal. Tudo que for alcançável via NFSe entrará na árvore dele.
        // Itens não alcançáveis via NFSe (ex: Evento solto) criarão suas próprias árvores.
        $roots = ['NFSe', 'evento', 'pedRegEvento', 'DPS']; 

        $queue = [];

        // Inicializar fila com os roots
        foreach ($roots as $rootName) {
            $element = $this->elements[$rootName] ?? null;
            if (!$element) continue;

            $type = isset($element['type']) ? $this->stripNamespace((string)$element['type']) : null;
            
            // Se o root não tem type nomeado, talvez seja complexType anônimo (não tratado aqui para map global)
            // Mas se tiver type, registramos ele na raiz (BaseNamespace)
            if ($type && isset($this->complexTypes[$type])) {
                // Se já foi mapeado (por um root anterior), ignoramos para manter precedência
                if (!isset($this->typeNamespaceMap[$type])) {
                    $this->registerTypeNamespace($type, $this->baseNamespace);
                    $queue[] = $type;
                }
            }
        }

        // BFS para processar filhos e aninhar namespaces
        $processed = 0;
        while (!empty($queue)) {
            $currentType = array_shift($queue);
            $currentNs = $this->typeNamespaceMap[$currentType];
            $currentClass = $this->getClassNameFromType($currentType);
            
            // O namespace para os filhos será: NamespaceAtual \ NomeClasseAtual
            // Ex: NFSe\InfNFSe
            $childNs = $currentNs . '\\' . $currentClass;

            $node = $this->complexTypes[$currentType];
            $properties = $this->extractProperties($node);

            foreach ($properties as $prop) {
                // Ignorar atributos simples ou tipos primitivos
                // Verificamos se o tipo da propriedade é um ComplexType conhecido
                $childType = $prop['type'];

                if (isset($this->complexTypes[$childType])) {
                    // Se ainda não foi mapeado, adote-o como filho
                    if (!isset($this->typeNamespaceMap[$childType])) {
                        $this->registerTypeNamespace($childType, $childNs);
                        $queue[] = $childType;
                    }
                }
            }
            $processed++;
        }

        echo "Hierarchy built. Processed {$processed} complex types via BFS.\n";
    }

    private function registerTypeNamespace(string $type, string $ns): void
    {
        $this->typeNamespaceMap[$type] = $ns;
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
    
    private function generateEnums(): void
    {
        echo "\nGenerating enums from simpleTypes...\n";
        
        $enumsDir = __DIR__ . "/../src/Enums/{$this->versionNamespace}";
        // Check se diretório existe, se não, criar (com permissão se possível, ou assumir user)
        // O código original fazia mkdir.
        if (is_dir($enumsDir)) {
             $this->rrmdir($enumsDir);
        }
        mkdir($enumsDir, 0755, true);
        
        $enumsGenerated = 0;
        
        foreach ($this->simpleTypes as $typeName => $typeNode) {
            // Registrar namespace
            $typeNode->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
            
            // Verificar se tem restrições de enumeração
            $enumerations = $typeNode->xpath('.//xs:restriction/xs:enumeration');
            
            if (!empty($enumerations)) {
                $enumName = Str::studly($typeName);
                $enumValues = [];
                
                foreach ($enumerations as $enum) {
                    $value = (string)$enum['value'];
                    
                    // Buscar documentação
                    $enum->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
                    $docNodes = $enum->xpath('.//xs:documentation');
                    $documentation = !empty($docNodes) ? trim((string)$docNodes[0]) : '';
                    
                    $enumValues[] = [
                        'value' => $value,
                        'documentation' => $documentation,
                    ];
                }
                
                // Gerar arquivo do enum
                $this->generateEnumFile($enumName, $enumValues, $typeName);
                $enumsGenerated++;
            }
        }
        
        echo "Generated {$enumsGenerated} enums\n";
    }
    
    private function generateEnumFile(string $enumName, array $values, string $originalName): void
    {
        $enumsDir = __DIR__ . "/../src/Enums/{$this->versionNamespace}";
        $filePath = $enumsDir . '/' . $enumName . '.php';
        
        // Determinar tipo do enum (int ou string)
        $firstValue = $values[0]['value'] ?? '';
        $isInt = is_numeric($firstValue);
        $enumType = $isInt ? 'int' : 'string';
        
        $content = "<?php\n\n";
        $content .= "namespace Nfse\\Enums\\{$this->versionNamespace};\n\n";
        $content .= "/**\n";
        $content .= " * {$enumName}\n";
        $content .= " * \n";
        $content .= " * Gerado automaticamente do schema XSD versão {$this->version}\n";
        $content .= " * Tipo original: {$originalName}\n";
        $content .= " */\n";
        $content .= "enum {$enumName}: {$enumType}\n";
        $content .= "{\n";
        
        foreach ($values as $enumValue) {
            $value = $enumValue['value'];
            $doc = $enumValue['documentation'];
            
            // Criar nome do case (remover caracteres especiais)
            $caseName = $this->generateEnumCaseName($value);
            
            if (!empty($doc)) {
                $content .= "    /**\n";
                $content .= "     * {$doc}\n";
                $content .= "     */\n";
            }
            
            $valueFormatted = $isInt ? $value : "'{$value}'";
            $content .= "    case {$caseName} = {$valueFormatted};\n\n";
        }
        
        $content .= "}\n";
        
        file_put_contents($filePath, $content);
        // echo "  ✓ {$enumName}\n";
    }
    
    private function generateEnumCaseName(string $value): string
    {
        // Se é numérico, prefixar com 'Value'
        if (is_numeric($value)) {
            return 'Value' . $value;
        }
        
        // Converter para PascalCase
        $name = Str::studly(str_replace(['-', '.', ' ', '/'], '_', $value));
        
        // Se começar com número, prefixar
        if (preg_match('/^[0-9]/', $name)) {
            $name = 'Value' . $name;
        }
        
        if (empty($name)) {
             return 'Empty';
        }

        return $name;
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
        $mainElements = ['DPS', 'NFSe', 'evento', 'pedRegEvento', 'Lote', 'lote'];
        
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
        
        // Elementos raiz devem ficar no namespace base?
        // Ou devemos checar se eles mapeiam para um tipo que foi aninhado?
        // Geralmente raiz = Entrypoint.
        // Se for um wrapper simples de um tipo complexo, podemos extender ou apenas gerar no base.
        // Vamos manter no baseNamespace para facilitar acesso.
        $namespace = $this->baseNamespace;
        $outputDir = $this->baseOutputDir;
        
        // Se o elemento tem um tipo, usar esse tipo
        if (isset($elementNode['type'])) {
            $typeName = $this->stripNamespace((string)$elementNode['type']);
            if (isset($this->complexTypes[$typeName])) {
                // Aqui é interessante: chamamos generateClassFromComplexType para o TIPO.
                // Isso vai gerar o arquivo no local correto da hierarquia.
                // Mas o método retorna o FQCN class name.
                // O Root Element em si pode ser apenas uma classe vazia que extende esse tipo?
                // Ou apenas geramos o tipo e assumimos que o user usa o tipo?
                // O código antigo gerava novamente.
                // Vamos manter o comportamento de gerar o tipo complexo onde ele deve estar.
                return $this->generateClassFromComplexType($typeName, $this->complexTypes[$typeName]);
            }
        }
        
        // Caso contrário, extrair propriedades inline (anonymous complexType)
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
        // Imports úteis
        $content .= "use NFSe\\Dto\\Attributes\\MapFrom;\n\n";

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

            // Attribute MapFrom (opcional, se quiser suportar mapeamento de nomes XML diferentes)
            // $content .= "    #[MapFrom('{$prop['name']}')]\n";
            
            // Tipo da propriedade
            if ($isArray) {
                // Docblock para array type hint poderia ser adicionado aqui
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
        // Remover prefixo 'TC' se existir (Tipo Complexo)
        if (str_starts_with($typeName, 'TC')) {
            $typeName = substr($typeName, 2);
        }
        // Remover prefixo 'T' se existir caso não seja TC (ex: TAlgumaCoisa)
        elseif (str_starts_with($typeName, 'T') && strlen($typeName) > 1 && ctype_upper($typeName[1])) {
            $typeName = substr($typeName, 1);
        }
        
        // Normalizar variações de case ANTES de converter para StudlyCase
        $typeName = str_replace(['Nfse', 'nfse'], 'NFSe', $typeName);
        $typeName = str_replace('Dps', 'DPS', $typeName);

        $className = Str::studly($typeName);
        
        return $className;
    }
    
    private function getNamespaceForType(string $typeName): string
    {
        // Verificar mapa gerado dinamicamente
        if (isset($this->typeNamespaceMap[$typeName])) {
            return $this->typeNamespaceMap[$typeName];
        }

        // Fallback: se não foi encontrado no BFS (órfão), joga num diretório Common
        return $this->baseNamespace . '\\Common';
    }
    
    private function getOutputDirForNamespace(string $namespace): string
    {
        $relativePath = str_replace($this->baseNamespace . '\\', '', $namespace);
        
        // Se for o próprio baseNamespace
        if ($namespace === $this->baseNamespace) {
            return $this->baseOutputDir;
        }

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
            'decimal' => 'string', // floats têm problemas de precisão para valores monetários
            'boolean' => 'bool',
            'date' => 'string',
            'dateTime' => 'string',
            'time' => 'string',
            'anyURI' => 'string',
            'base64Binary' => 'string',
            'nonNegativeInteger' => 'int',
        ];
        
        // Remover prefixo xs: se existir
        $xsdType = $this->stripNamespace($xsdType);
        
        // Se é um tipo complexo, retornar o nome da classe fully qualified
        if (isset($this->complexTypes[$xsdType])) {
            return '\\' . $this->getNamespaceForType($xsdType) . '\\' . $this->getClassNameFromType($xsdType);
        }
        
        // Se for um tipo simples com Enum?
        if (isset($this->simpleTypes[$xsdType])) {
             // Verificar se geramos um Enum para ele
             $typeNode = $this->simpleTypes[$xsdType];
             $typeNode->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
             $enumerations = $typeNode->xpath('.//xs:restriction/xs:enumeration');
             if (!empty($enumerations)) {
                 $enumName = Str::studly($xsdType);
                 return "\\Nfse\\Enums\\{$this->versionNamespace}\\{$enumName}";
             }
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
$version = $argv[1] ?? '1.0.1';

try {
    $generator = new XsdDtoGenerator($version);
    $generator->generate();
    echo "\n✓ DTOs gerados com sucesso!\n";
} catch (Exception $e) {
    echo "\n✗ Erro: " . $e->getMessage() . "\n";
    exit(1);
}
