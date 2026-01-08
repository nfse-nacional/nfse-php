<?php

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

$root = $dom->createElementNS('http://www.sped.fazenda.gov.br/nfse', 'NFSe');
$root->setAttribute('versao', '1.00');
$dom->appendChild($root);

$inf = $dom->createElement('infNFSe');
$inf->setAttribute('Id', '123');
$inf->setAttribute('versao', '1.00');
$root->appendChild($inf);

$el = $dom->createElement('xTribNac');
$el->appendChild($dom->createTextNode('Clínicas, sanatórios, manicômios, casas de saúde, prontos-socorros, ambulatórios e congêneres.'));
$inf->appendChild($el);

$xml = $dom->saveXML();

echo "Generated XML:\n".$xml."\n";

$simpleXml = simplexml_load_string($xml);
$json = json_encode($simpleXml);
$array = json_decode($json, true);

print_r($array);
