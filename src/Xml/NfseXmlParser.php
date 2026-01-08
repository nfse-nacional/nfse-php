<?php

namespace Nfse\Xml;

use Exception;
use Nfse\Dto\Nfse\NfseData;

class NfseXmlParser
{
    public function parse(string $xml): NfseData
    {
        // Clean up the XML string
        $xml = trim($xml);

        // Try to detect if the XML has double UTF-8 encoding
        // This happens when the SEFIN API returns XML that was already UTF-8 encoded
        // and then got encoded again during transmission
        $hasDoubleEncoding = $this->detectDoubleUtf8Encoding($xml);

        if ($hasDoubleEncoding) {
            // Decode once to fix the double encoding
            $xml = mb_convert_encoding($xml, 'ISO-8859-1', 'UTF-8');
        }

        // Load with proper encoding options
        $simpleXml = simplexml_load_string(
            $xml,
            'SimpleXMLElement',
            LIBXML_NOCDATA | LIBXML_NOBLANKS
        );

        if ($simpleXml === false) {
            throw new Exception('Failed to parse XML');
        }

        // Use JSON_UNESCAPED_UNICODE to preserve characters correctly
        $json = json_encode($simpleXml, JSON_UNESCAPED_UNICODE);
        $parsedDoc = json_decode($json, true);

        return new NfseData($parsedDoc);
    }

    /**
     * Detect if the XML has double UTF-8 encoding
     *
     * This checks for the pattern where UTF-8 multi-byte characters are double-encoded
     * For example: "ç" (0xC3 0xA7) becomes "Ã§" (0xC3 0x83 0xC2 0xA7)
     */
    private function detectDoubleUtf8Encoding(string $xml): bool
    {
        // Look for the double-encoding pattern: 0xC3 0x83 or 0xC3 0x82
        // This is a strong indicator of double UTF-8 encoding
        return preg_match('/\xC3[\x82\x83]/', $xml) === 1;
    }
}
