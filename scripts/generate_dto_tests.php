<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Str;

class DtoTestGenerator
{
    private array $tree = [];
    private string $baseNamespace = 'Nfse\\Tests\\Unit\\Dto\\Generated';
    private string $baseOutputDir = __DIR__ . '/../tests/Unit/Dto/Generated';

    public function handle()
    {
        $csvFile = __DIR__ . '/../references/schemas/dps-nfse-schema.csv';
        if (!file_exists($csvFile)) {
            echo "CSV file not found: $csvFile\n";
            exit(1);
        }

        if (!is_dir($this->baseOutputDir)) {
            mkdir($this->baseOutputDir, 0755, true);
        }

        $handle = fopen($csvFile, 'r');
        if ($handle === false) {
            echo "Unable to open CSV file.\n";
            exit(1);
        }

        echo "Reading CSV for Tests...\n";
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) < 4) continue;

            $path = trim($data[1]);
            $field = trim($data[2]);
            $description = trim($data[3]);

            if ($path === 'CAMINHO NO XML' || $path === '-' || empty($path)) continue;
            if (empty($field) || $field === '-') continue;

            $this->addToTree($path, $field, $description);
        }
        fclose($handle);

        echo "Generating tests...\n";
        foreach ($this->tree as $name => $node) {
            $this->generateTest($name, $node, $this->baseNamespace, $this->baseOutputDir);
        }
        echo "Done.\n";
    }

    private function addToTree(string $path, string $field, string $description)
    {
        $parts = explode('/', trim($path, '/'));
        $current = &$this->tree;
        $targetNode = null;

        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                $current[$part] = [
                    'fields' => [],
                    'children' => []
                ];
            }
            $targetNode = &$current[$part];
            $current = &$targetNode['children'];
        }

        if ($targetNode) {
            $targetNode['fields'][$field] = [
                'name' => $field,
                'description' => $description
            ];
        }
    }

    private function generateTest(string $nodeName, array $nodeData, string $namespace, string $outputDir)
    {
        $dtoClassName = Str::studly($nodeName);
        if (str_ends_with($dtoClassName, 'Dto')) {
             $dtoClassName = substr($dtoClassName, 0, -3);
        }
        $dtoClassName .= 'Data';
        $testClassName = $dtoClassName . 'Test';

        // Prepare child tests first
        $childProperties = [];
        foreach ($nodeData['children'] as $childName => $childNode) {
            $subFolderName = Str::studly($nodeName);
            $subNamespace = $namespace . '\\' . $subFolderName;
            $subOutputDir = $outputDir . '/' . $subFolderName;
            
            if (!is_dir($subOutputDir)) {
                mkdir($subOutputDir, 0755, true);
            }
            
            $this->generateTest($childName, $childNode, $subNamespace, $subOutputDir);
            $childProperties[] = $childName;
            
            // Check if child property name matches key or needs case adjustment? 
            // In DTO generator we kept original name.
        }

        // Calculate DTO Class FQCN
        // Test Namespace: Nfse\Tests\Unit\Dto\Generated...
        // DTO Namespace:  Nfse\Dto... (without Generated)
        // Adjust logical path for DTOs. 
        // Logic in generate_dtos.php: $baseDetails['namespace'] . $parentNamespaceSuffix
        // If current namespace is Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe
        // DTO namespace should be Nfse\Dto\NFSe\InfNFSe
        
        $dtoNamespace = str_replace('Nfse\\Tests\\Unit\\Dto\\Generated', 'Nfse\\Dto', $namespace);
        // Handle root namespace case if needed, but recursive usually appends
        
        $dtoFqcn = $dtoNamespace . '\\' . $dtoClassName;

        $content = "<?php\n\n";
        $content .= "namespace {$namespace};\n\n";
        $content .= "use {$dtoFqcn};\n\n";
        
        $content .= "it('can instantiate {$dtoClassName} via map helper', function () {\n";
        // Valinor map requires data
        $content .= "    \$dto = \map({$dtoClassName}::class, []);\n";
        $content .= "    expect(\$dto)->toBeInstanceOf({$dtoClassName}::class);\n";
        $content .= "});\n\n";

        // generate set properties test
        $scalarFields = [];
        foreach ($nodeData['fields'] as $field) {
            $fName = $field['name'];
            if (!in_array($fName, $childProperties)) {
                $scalarFields[] = $fName;
            }
        }

        if (count($scalarFields) > 0) {
            $content .= "it('can map properties for {$dtoClassName}', function () {\n";
            $content .= "    \$data = [\n";
            foreach ($scalarFields as $fName) {
                // Using scalar value string
                $content .= "        '{$fName}' => 'test',\n";
            }
            $content .= "    ];\n\n";
            $content .= "    \$dto = \map({$dtoClassName}::class, \$data);\n\n";
            
            foreach ($scalarFields as $fName) {
                // Property name relies on how generate_dtos.php names them. 
                // In generate_dtos.php: $propName = $fieldName; (original casing)
                $propName = $fName; 
                $content .= "    expect(\$dto->{$propName})->toBe('test');\n";
            }
            $content .= "});\n";
        }

        $filePath = $outputDir . '/' . $testClassName . '.php';
        file_put_contents($filePath, $content);
    }
}

$generator = new DtoTestGenerator();
$generator->handle();
