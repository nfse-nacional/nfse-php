#!/usr/bin/env php
<?php

/**
 * Gerador de testes para DTOs versionados
 * 
 * Gera testes automaticamente para todos os DTOs de uma versão específica
 * 
 * Uso: php scripts/generate_dto_tests.php [versao]
 * Exemplo: php scripts/generate_dto_tests.php 1.0.0
 */

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Str;

class VersionedDtoTestGenerator
{
    private string $version;
    private string $versionNamespace;
    private string $dtoDir;
    private string $testDir;
    private int $testsGenerated = 0;
    
    public function __construct(string $version = '1.0.0')
    {
        $this->version = $version;
        $this->versionNamespace = 'V' . str_replace('.', '_', $version);
        $this->dtoDir = __DIR__ . "/../src/Dto/{$this->versionNamespace}";
        $this->testDir = __DIR__ . "/../tests/Unit/Dto/{$this->versionNamespace}";
        
        if (!is_dir($this->dtoDir)) {
            throw new Exception("DTO directory not found: {$this->dtoDir}");
        }
    }
    
    public function generate(): void
    {
        echo "🧪 Gerando testes para DTOs versão {$this->version}...\n\n";
        
        // Limpar diretório de testes
        if (is_dir($this->testDir)) {
            $this->rrmdir($this->testDir);
        }
        mkdir($this->testDir, 0755, true);
        
        // Coletar todos os DTOs
        $dtoFiles = $this->collectDtoFiles($this->dtoDir);
        
        echo "📁 Encontrados " . count($dtoFiles) . " DTOs\n\n";
        
        // Gerar teste para cada DTO
        foreach ($dtoFiles as $dtoFile) {
            $this->generateTestForDto($dtoFile);
        }
        
        echo "\n✅ {$this->testsGenerated} testes gerados com sucesso!\n";
        echo "📂 Testes salvos em: {$this->testDir}\n";
    }
    
    private function collectDtoFiles(string $dir): array
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        
        sort($files);
        return $files;
    }
    
    private function generateTestForDto(string $dtoFile): void
    {
        // Extrair informações do DTO
        $relativePath = str_replace($this->dtoDir . '/', '', $dtoFile);
        $className = basename($dtoFile, '.php');
        
        // Determinar namespace do DTO
        $dtoNamespace = $this->getDtoNamespace($relativePath);
        $fullClassName = $dtoNamespace . '\\' . $className;
        
        // Determinar namespace do teste
        $testNamespace = str_replace('NFSe\\Dto\\', 'Nfse\\Tests\\Unit\\Dto\\', $dtoNamespace);
        
        // Extrair propriedades do DTO
        $properties = $this->extractProperties($dtoFile);
        
        // Gerar conteúdo do teste
        $testContent = $this->generateTestContent(
            $testNamespace,
            $className,
            $fullClassName,
            $properties
        );
        
        // Determinar caminho do arquivo de teste
        $testRelativePath = str_replace('.php', 'Test.php', $relativePath);
        $testFile = $this->testDir . '/' . $testRelativePath;
        
        // Criar diretórios necessários
        $testFileDir = dirname($testFile);
        if (!is_dir($testFileDir)) {
            mkdir($testFileDir, 0755, true);
        }
        
        // Salvar teste
        file_put_contents($testFile, $testContent);
        $this->testsGenerated++;
        
        echo "  ✓ {$relativePath}\n";
    }
    
    private function getDtoNamespace(string $relativePath): string
    {
        $dir = dirname($relativePath);
        if ($dir === '.') {
            return "NFSe\\Dto\\{$this->versionNamespace}";
        }
        
        $namespaceParts = explode('/', $dir);
        $namespaceParts = array_map([Str::class, 'studly'], $namespaceParts);
        
        return "NFSe\\Dto\\{$this->versionNamespace}\\" . implode('\\', $namespaceParts);
    }
    
    private function extractProperties(string $file): array
    {
        $content = file_get_contents($file);
        preg_match_all('/public\s+(\??)([\w\\\\]+)\s+\$(\w+)(\s*=\s*(.+?))?;/s', $content, $matches, PREG_SET_ORDER);
        
        $properties = [];
        foreach ($matches as $match) {
            $isOptional = $match[1] === '?';
            $type = trim($match[2]);
            $name = $match[3];
            $defaultValue = isset($match[5]) ? trim($match[5]) : null;
            
            // Determinar tipo de exemplo
            $exampleValue = $this->getExampleValue($type, $isOptional);
            
            $properties[] = [
                'name' => $name,
                'type' => $type,
                'isOptional' => $isOptional,
                'defaultValue' => $defaultValue,
                'exampleValue' => $exampleValue,
            ];
        }
        
        return $properties;
    }
    
    private function getExampleValue(string $type, bool $isOptional): string
    {
        // Remover namespace do tipo
        $baseType = basename(str_replace('\\', '/', $type));
        
        // Tipos primitivos
        $primitiveExamples = [
            'string' => "'exemplo'",
            'int' => '123',
            'float' => '123.45',
            'bool' => 'true',
            'array' => '[]',
        ];
        
        if (isset($primitiveExamples[$baseType])) {
            return $primitiveExamples[$baseType];
        }
        
        // Se é um DTO, retornar array vazio para map()
        if (str_contains($type, 'Data')) {
            return '[]';
        }
        
        return "'valor'";
    }
    
    private function generateTestContent(
        string $testNamespace,
        string $className,
        string $fullClassName,
        array $properties
    ): string {
        $testName = str_replace('Data', '', $className);
        
        $content = "<?php\n\n";
        $content .= "namespace {$testNamespace};\n\n";
        $content .= "use {$fullClassName};\n\n";
        
        // Teste de instanciação via map()
        $content .= "it('can instantiate {$testName} via map helper', function () {\n";
        $content .= "    \$data = [\n";
        
        // Adicionar propriedades de exemplo (apenas não-opcionais)
        $requiredProps = array_filter($properties, fn($p) => !$p['isOptional']);
        foreach ($requiredProps as $prop) {
            $content .= "        '{$prop['name']}' => {$prop['exampleValue']},\n";
        }
        
        $content .= "    ];\n\n";
        $content .= "    \$dto = \\map({$className}::class, \$data);\n\n";
        $content .= "    expect(\$dto)->toBeInstanceOf({$className}::class);\n";
        
        // Verificar propriedades obrigatórias
        foreach ($requiredProps as $prop) {
            if ($prop['type'] === 'string') {
                $content .= "    expect(\$dto->{$prop['name']})->toBe({$prop['exampleValue']});\n";
            }
        }
        
        $content .= "});\n\n";
        
        // Teste de mapeamento de propriedades
        if (!empty($properties)) {
            $content .= "it('can map properties for {$testName}', function () {\n";
            $content .= "    \$data = [\n";
            
            foreach ($properties as $prop) {
                $content .= "        '{$prop['name']}' => {$prop['exampleValue']},\n";
            }
            
            $content .= "    ];\n\n";
            $content .= "    \$dto = \\map({$className}::class, \$data);\n\n";
            
            foreach ($properties as $prop) {
                $content .= "    expect(\$dto->{$prop['name']})->not->toBeNull();\n";
            }
            
            $content .= "});\n";
        }
        
        return $content;
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

// Processar argumentos
$version = $argv[1] ?? '1.0.0';

try {
    $generator = new VersionedDtoTestGenerator($version);
    $generator->generate();
} catch (Exception $e) {
    echo "\n❌ Erro: " . $e->getMessage() . "\n";
    exit(1);
}
