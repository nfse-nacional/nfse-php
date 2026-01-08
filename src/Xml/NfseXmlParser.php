<?php

namespace Nfse\Xml;

use Exception;
use Nfse\Dto\Nfse\NfseData;

class NfseXmlParser
{
    public function parse(string $xml): NfseData
    {
        // 1. Fix Encoding
        if (! mb_check_encoding($xml, 'UTF-8')) {
            $xml = mb_convert_encoding($xml, 'UTF-8', 'ISO-8859-1');
        }

        // Remove invalid characters
        $xml = iconv('UTF-8', 'UTF-8//IGNORE', $xml);

        // Remove escaped quotes if present (e.g. from JSON dumps)
        $xml = str_replace('\"', '"', $xml);

        // 2. Parse XML
        $useInternal = libxml_use_internal_errors(true);
        $simpleXml = simplexml_load_string(
            $xml,
            'SimpleXMLElement',
            LIBXML_NOCDATA | LIBXML_NOBLANKS | LIBXML_RECOVER
        );

        if ($simpleXml === false) {
            $errors = libxml_get_errors();
            $errorMsg = $errors[0]->message ?? 'Failed to parse XML';
            libxml_clear_errors();
            libxml_use_internal_errors($useInternal);
            throw new Exception($errorMsg);
        }
        libxml_use_internal_errors($useInternal);

        // 3. Convert to Array via JSON (mimic vendor behavior)
        $json = json_encode($simpleXml, JSON_UNESCAPED_UNICODE);
        $parsedDoc = json_decode($json, true);

        // 4. Sanitize Array (Fix [] -> null)
        $parsedDoc = $this->sanitizeArray($parsedDoc);

        return new NfseData($parsedDoc);
    }

    private function sanitizeArray($data)
    {
        if (! is_array($data)) {
            return $data;
        }

        if (empty($data)) {
            return null;
        }

        foreach ($data as $key => $value) {
            $data[$key] = $this->sanitizeArray($value);
        }

        return $data;
    }
}
