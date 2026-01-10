<?php

use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\NfseData;
use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Signer\Certificate;
use Nfse\Signer\XmlSigner;
use Nfse\Xml\DpsXmlBuilder;
use Nfse\Xml\EventosXmlBuilder;
use Nfse\Xml\NfseXmlBuilder;

test('XmlSigner should not contain newlines, carriage returns or tabs', function () {
    $certPath = __DIR__.'/../../fixtures/certs/test.pfx';
    $password = '1234';
    $certificate = new Certificate($certPath, $password);
    $signer = new XmlSigner($certificate);

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
           '<root>'."\n".
           '  <infDPS Id="DPS123">'."\n".
           '    <test>value</test>'."\n".
           '  </infDPS>'."\n".
           '</root>';

    $signedXml = $signer->sign($xml, 'infDPS');

    expect($signedXml)->not->toContain("\n");
    expect($signedXml)->not->toContain("\r");
    expect($signedXml)->not->toContain("\t");
});

test('DpsXmlBuilder should not contain newlines, carriage returns or tabs', function () {
    $builder = new DpsXmlBuilder;
    DpsData::from([
        'versao' => '1.00',
        'infDPS' => [
            'Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
        ],
    ]);

    $xml = $builder->build($dpsData);

    expect($xml)->not->toContain("\n");
    expect($xml)->not->toContain("\r");
    expect($xml)->not->toContain("\t");
});

test('NfseXmlBuilder should not contain newlines, carriage returns or tabs', function () {
    $builder = new NfseXmlBuilder;
    $nfseData = new NfseData([
        'versao' => '1.00',
        'infNFSe' => [
            'Id' => 'NFSe123',
            'nNFSe' => '1',
            'cVerif' => '123456',
            'dhProc' => '2023-01-01T10:00:00',
            'cStat' => '100',
            'ambGer' => 2,
            'tpEmis' => 1,
            'procEmi' => 1,
            'verAplic' => '1.0',
        ],
    ]);

    $xml = $builder->build($nfseData);

    expect($xml)->not->toContain("\n");
    expect($xml)->not->toContain("\r");
    expect($xml)->not->toContain("\t");
});

test('EventosXmlBuilder should not contain newlines, carriage returns or tabs', function () {
    $builder = new EventosXmlBuilder;
    $eventoData = new PedRegEventoData([
        'versao' => '1.00',
        'infPedReg' => [
            'tpAmb' => 2,
            'verAplic' => '1.0',
            'dhEvento' => '2023-01-01T10:00:00',
            'chNFSe' => '12345678901234567890123456789012345678901234',
            'nPedRegEvento' => 1,
            'tpEvento' => '101101',
            'e101101' => [
                'xDesc' => 'Cancelamento',
                'cMotivo' => '1',
                'xMotivo' => 'Erro de preenchimento',
            ],
        ],
    ]);

    $xml = $builder->buildPedRegEvento($eventoData);

    expect($xml)->not->toContain("\n");
    expect($xml)->not->toContain("\r");
    expect($xml)->not->toContain("\t");
});
