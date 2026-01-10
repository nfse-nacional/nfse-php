<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Str;

class DtoGenerator
{
    private array $tree = [];
    private string $baseNamespace = 'Nfse\\Dto';
    private string $baseOutputDir = __DIR__ . '/../src/Dto';

    public function handle()
    {
        $csvFile = __DIR__ . '/../references/schemas/dps-nfse-schema.csv';
        if (!file_exists($csvFile)) {
            echo "CSV file not found: $csvFile\n";
            exit(1);
        }

        // Clean up base output dir
        if (!is_dir($this->baseOutputDir)) {
            mkdir($this->baseOutputDir, 0755, true);
        }

        $handle = fopen($csvFile, 'r');
        if ($handle === false) {
            echo "Unable to open CSV file.\n";
            exit(1);
        }

        echo "Reading CSV...\n";
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Adjust indices based on your CSV structure
            // 1: Path (e.g., NFSe/infNFSe/valores/)
            // 2: Field Name (e.g., vCalcDR)
            // 3: Description
            
            if (count($data) < 4) continue;

            $path = trim($data[1]);
            $field = trim($data[2]);
            $description = trim($data[3]);

            // Skip header and invalid paths
            if ($path === 'CAMINHO NO XML' || $path === '-' || empty($path)) continue;
            if (empty($field) || $field === '-') continue;

            $this->addToTree($path, $field, $description);
        }
        fclose($handle);

        echo "Generating classes...\n";
        foreach ($this->tree as $name => $node) {
            $this->generateClass($name, $node, $this->baseNamespace, $this->baseOutputDir);
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

    private function generateClass(string $nodeName, array $nodeData, string $namespace, string $outputDir)
    {
        $className = Str::studly($nodeName);
        if (!str_ends_with($className, 'Dto')) {
            $className .= 'Dto'; 
        }
        
        if (str_ends_with($className, 'Dto')) {
             $className = substr($className, 0, -3);
        }
        $className .= 'Data';

        // Prepare child classes first to identify keys
        $childProperties = [];
        foreach ($nodeData['children'] as $childName => $childNode) {
            // Hierarchy: Child in Subfolder named after Parent Class (Node Name studly)
            $subFolderName = Str::studly($nodeName);
            $subNamespace = $namespace . '\\' . $subFolderName;
            $subOutputDir = $outputDir . '/' . $subFolderName;
            
            if (!is_dir($subOutputDir)) {
                mkdir($subOutputDir, 0755, true);
            }
            
            $childClassFQCN = $this->generateClass($childName, $childNode, $subNamespace, $subOutputDir);
            $childProperties[$childName] = $childClassFQCN;
        }

        $content = "<?php\n\n";
        $content .= "namespace {$namespace};\n\n";
        // Removed Dto and MapFrom imports
        // use CuyZ\Valinor\Mapper\Source\Source; // No longer needed per user request

        $content .= "class {$className} \n";
        $content .= "{\n";

        // Properties from CSV fields
        foreach ($nodeData['fields'] as $field) {
            $fieldName = $field['name'];
            
            // Skip if this field is actually a child node (exists in childProperties)
            if (isset($childProperties[$fieldName])) {
                continue;
            }

            // Using fieldName directly as property name if we want exact mapping, or use camelCase and Valinor's superfluous keys + casing support.
            // But Valinor maps to property names. If XML has 'cMun', property should ideally be $cMun or we use Source attribute.
            // User specifically asked NO Source attribute.
            // So we MUST use the exact name from XML as the property name for auto-mapping to work easily.
            // Or rely on `map('c_mun', ...)` normalization but that's complex.
            // Safest bet for "no source attribute" is to match property name to input key.
            // Input keys from XML are like 'cMun'. Property should be $cMun.
            
            $propName = $fieldName; // Keep original casing for exact match
            
            $desc = $field['description'];
            $descLines = explode("\n", wordwrap($desc, 100));
            
            $content .= "    /**\n";
            foreach ($descLines as $line) {
                $content .= "     * " . trim($line) . "\n";
            }
            $content .= "     */\n";
            // Removed #[Source]
            $content .= "    public ?string \${$propName} = null;\n\n"; 
        }

        // Properties from Children (Nested DTOs)
        foreach ($childProperties as $childKey => $fqcn) {
            $propName = $childKey; // Keep original casing
            $desc = '';
            
            $typeHint = '\\' . $fqcn;

            if (isset($nodeData['fields'][$childKey])) {
                 $desc = $nodeData['fields'][$childKey]['description'];
                 if ($desc === '-') $desc = '';
            }

            $content .= "    /**\n";
             if (!empty($desc)) {
                $descLines = explode("\n", wordwrap($desc, 100));
                foreach ($descLines as $line) {
                    $content .= "     * " . trim($line) . "\n";
                }
            }
            $content .= "     * @var {$typeHint}|null\n";
            $content .= "     */\n";
            // Removed #[Source]
            $content .= "    public ?{$typeHint} \${$propName} = null;\n\n";
        }

        $content .= "}\n";

        $filePath = $outputDir . '/' . $className . '.php';
        file_put_contents($filePath, $content);

        return $namespace . '\\' . $className;
    }
}

$generator = new DtoGenerator();
$generator->handle();
