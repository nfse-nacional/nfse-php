<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Xml\NfseXmlBuilder;
use Nfse\Xml\NfseXmlParser;

it('can build nfse xml from parsed fixture data', function () {
    $xmlContent = file_get_contents(__DIR__.'/../../fixtures/nfse.xml');

    // 1. Parse the XML
    $parser = new NfseXmlParser;
    $nfseData = $parser->parse($xmlContent);

    // 2. Build XML from the parsed data
    $builder = new NfseXmlBuilder;
    $builtXml = $builder->build($nfseData);

    // 3. Assertions
    // We check if key elements are present in the built XML.
    // Exact string comparison is difficult due to potential differences in attribute order or whitespace,
    // and because the builder might not generate the Signature block or might order tags differently.

    expect($builtXml)->toContain('<NFSe xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.00">')
        ->and($builtXml)->toContain('<infNFSe Id="NFS15054862231305199000190000000000000225121645026250" versao="1.00">')
        ->and($builtXml)->toContain('<xLocEmi>Pacajá</xLocEmi>')
        ->and($builtXml)->toContain('<nNFSe>2</nNFSe>')
        ->and($builtXml)->toContain('<cLocIncid>1505486</cLocIncid>')
        ->and($builtXml)->toContain('<emit>')
        ->and($builtXml)->toContain('<CNPJ>31305199000190</CNPJ>')
        ->and($builtXml)->toContain('<xNome>DINAMARQUES T SANTOS</xNome>')
        ->and($builtXml)->toContain('<DPS versao="1.00">')
        ->and($builtXml)->toContain('<infDPS Id="DPS150548623130519900019000900000000000000003">')
        ->and($builtXml)->toContain('<nDPS>3</nDPS>')
        ->and($builtXml)->toContain('<vServ>230.00</vServ>');

    // dump($builtXml);

    // Check if values match
    $parsedBuiltXml = $parser->parse($builtXml);

    expect($parsedBuiltXml->infNfse->id)->toBe($nfseData->infNfse->id)
        ->and($parsedBuiltXml->infNfse->numeroNfse)->toBe($nfseData->infNfse->numeroNfse)
        ->and($parsedBuiltXml->infNfse->emitente->cnpj)->toBe($nfseData->infNfse->emitente->cnpj)
        ->and($parsedBuiltXml->infNfse->dps->infDps->id)->toBe($nfseData->infNfse->dps->infDps->id);

});
