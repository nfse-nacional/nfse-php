<?php

namespace Nfse\Xml;

use DOMDocument;
use DOMElement;
use CuyZ\Valinor\Normalizer\Format;
use CuyZ\Valinor\NormalizerBuilder;
use Nfse\Dto\NFSe\InfNFSe\DPSData;

class DpsXmlBuilder
{
    private DOMDocument $dom;

    public function build(DPSData $dps): string
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = false;
        $this->dom->encoding = 'UTF-8';

        // Normalize DTO to array using Valinor
        $normalizer = (new NormalizerBuilder())
            ->normalizer(Format::array());
        
        $data = $normalizer->normalize($dps);

        // Remove nulls recursively? Or handle in loop. 
        // Normalizer keeps nulls for nullable properties.
        // We will remove them consistently during traversal.

        $root = $this->dom->createElementNS('http://www.sped.fazenda.gov.br/nfse', 'DPS');
        
        // Handle Root Attribute 'versao'
        if (isset($data['versao'])) {
            $root->setAttribute('versao', (string) $data['versao']);
            unset($data['versao']);
        }
        
        $this->dom->appendChild($root);

        // Handle specific structure if needed, or just iterate.
        // We know 'infDPS' is the main child.
        if (isset($data['infDPS'])) {
            $infDpsData = $data['infDPS'];
            unset($data['infDPS']); // Remove from main loop if we handle it here

            $infDps = $this->dom->createElement('infDPS');
            
            // Handle infDPS Attribute 'Id' (or 'id' depending on DTO property casing)
            // The generated DTO property usually matches the CSV column.
            // Assuming property is 'Id' or 'id'. Let's check both or permissive.
            // Step 248 test used keys: 'Id' in @attributes for old test, but user generated DTOs might use 'id'.
            // Most XML schemas use 'Id' (capital I). The property generator uses exact match from CSV.
            // Let's assume 'Id' if CSV provided 'Id'.
            
            if (isset($infDpsData['Id'])) {
                $infDps->setAttribute('Id', (string) $infDpsData['Id']);
                unset($infDpsData['Id']);
            } elseif (isset($infDpsData['id'])) {
                 $infDps->setAttribute('Id', (string) $infDpsData['id']);
                 unset($infDpsData['id']);
            }

            $root->appendChild($infDps);
            
            $this->buildRecursive($infDps, $infDpsData);
        }

        // Process any other root elements if they exist (Signature, values?)
        // In the schema, 'Signature' is usually after infDPS if at all.
        // 'valores' is usually INSIDE infDPS in the object model, OR outside? 
        // Step 233 showed `valores` as property of DPSData.
        // If it was in DPSData property, it stays in $data after unsetting infDPS.
        // We should just recurse whatever is left in $data into $root.

        $this->buildRecursive($root, $data);

        $xml = $this->dom->saveXML($root);

        return str_replace(["\n", "\r", "\t"], '', $xml);
    }

    private function buildRecursive(DOMElement $parent, array $data): void
    {
        foreach ($data as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (is_array($value)) {
                // Check if it's a list (numeric keys) -> repeated elements
                if (array_is_list($value) && !empty($value)) {
                    foreach ($value as $item) {
                        // For repeated elements, the key ($key) is the tag name.
                        // However, usually lists are wrapper properties in DTOs?
                        // If the DTO has `public array $itemList`, valinor normalizes property `itemList` => [item1, item2].
                        // In XML, we often want <itemName>...</itemName><itemName>...</itemName>.
                        // But sometimes there's a wrapper tag <itemList> ... </itemList>.
                        // Our usage of Valinor matches the structure.
                        // If the DTO structure matches XML structure (wrapper object for list), it will be handled naturally.
                        // If we have a list of Dto objects directly assigned to a property 'docDedRed', 
                        // validation: if $value is array of objects/arrays, and $key is 'docDedRed', likely we want multiple <docDedRed>.
                        
                        // If the DTO structure is exactly mapped to XML, array properties usually imply child elements.
                        // Assuming the property name IS the tag name.
                        
                        if (is_array($item)) {
                             $child = $this->dom->createElement($key);
                             $parent->appendChild($child);
                             $this->buildRecursive($child, $item);
                        } else {
                             // List of scalars?
                             $child = $this->dom->createElement($key, (string) $item);
                             $parent->appendChild($child);
                        }
                    }
                } else {
                    // Associative array -> single child element with nested children
                    $child = $this->dom->createElement($key);
                    $parent->appendChild($child);
                    $this->buildRecursive($child, $value);
                }
            } else {
                // Scalar value -> text content
                // Handle booleans, dates?
                // Normalizer usually outputs strings or ints/floats.
                if (is_bool($value)) {
                    $value = $value ? '1' : '0'; // Or 'true'/'false'? NFSe often uses 1/0? Check schema.
                }
                
                $child = $this->dom->createElement($key, (string) $value);
                $parent->appendChild($child);
            }
        }
    }

    private function appendElement(DOMElement $parent, string $name, mixed $value): void
    {
        if ($value instanceof \BackedEnum) {
            $value = $value->value;
        }

        if ($value !== null && $value !== '') {
            $element = $this->dom->createElement($name);
            $element->appendChild($this->dom->createTextNode((string) $value));
            $parent->appendChild($element);
        }
    }
}
