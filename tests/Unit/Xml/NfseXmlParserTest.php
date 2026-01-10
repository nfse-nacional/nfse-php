<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\NFSeData;
use Nfse\Xml\NfseXmlBuilder;
use Nfse\Xml\NfseXmlParser;

it('can parse nfse xml to data', function () {
    $nfse = new NfseData([
        '@attributes' => ['versao' => '1.00'],
        'infNFSe' => [
            '@attributes' => ['Id' => 'NFS123456'],
            'nNFSe' => '100',
            'nDFSe' => '987654321',
            'cVerif' => 'ABCDEF',
            'dhProc' => '2023-01-01T12:00:00',
            'ambGer' => 2,
            'verAplic' => '1.0',
            'procEmi' => 1,
            'xLocEmi' => 'VARZEA ALEGRE',
            'xLocPrestacao' => 'VARZEA ALEGRE',
            'cLocIncid' => '2314003',
            'xLocIncid' => 'VARZEA ALEGRE',
            'xTribNac' => 'Enfermagem...',
            'xTribMun' => '04.06 - Enfermagem...',
            'cStat' => 100,
            'DPS' => [
                '@attributes' => ['versao' => '1.00'],
                'infDPS' => [
                    '@attributes' => ['Id' => 'DPS123'],
                    'tpAmb' => 2,
                    'dhEmi' => '2023-01-01',
                    'verAplic' => '1.0',
                    'serie' => '1',
                    'nDPS' => '100',
                    'dCompet' => '2023-01-01',
                    'tpEmit' => 1,
                    'cLocEmi' => '1234567',
                    'prest' => null,
                    'toma' => null,
                    'interm' => null,
                    'serv' => null,
                    'valores' => null,
                ],
            ],
            'emit' => [
                'CNPJ' => '12345678000199',
                'CPF' => null,
                'IM' => '12345',
                'xNome' => 'Prefeitura Municipal',
                'xFant' => 'Secretaria de Finanças',
                'enderNac' => [
                    'xLgr' => 'Praça da Sé',
                    'nro' => '1',
                    'xCpl' => null,
                    'xBairro' => 'Centro',
                    'cMun' => '3550308',
                    'UF' => 'SP',
                    'CEP' => '01001000',
                ],
                'fone' => '1112345678',
                'email' => 'contato@prefeitura.sp.gov.br',
            ],
            'valores' => [
                'vCalcDR' => null,
                'tpBM' => null,
                'vCalcBM' => null,
                'vBC' => 1850.00,
                'pAliqAplic' => 5.00,
                'vISSQN' => 92.50,
                'vTotalRet' => null,
                'vLiq' => 1757.50,
            ],
        ],
    ]);

    $builder = new NfseXmlBuilder;
    $xml = $builder->build($nfse);

    $parser = new NfseXmlParser;
    $parsedNfse = $parser->parse($xml);

    expect($parsedNfse)->toBeInstanceOf(NfseData::class)
        ->and($parsedNfse->versao)->toBe('1.00')
        ->and($parsedNfse->infNfse->id)->toBe('NFS123456')
        ->and($parsedNfse->infNfse->numeroNfse)->toBe('100')
        ->and($parsedNfse->infNfse->dps->infDps->id)->toBe('DPS123')
        ->and($parsedNfse->infNfse->emitente->cnpj)->toBe('12345678000199');
});
