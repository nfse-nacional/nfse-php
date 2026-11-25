<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

function dpsLeiauteNt009(?string $finNfse, ?string $motivoEmisTI = null): DpsData
{
    return new DpsData([
        '@attributes' => ['versao' => '1.01'],
        'infDPS' => [
            '@attributes' => ['Id' => IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001')],
            'tpAmb' => 2,
            'dhEmi' => '2026-10-28T10:00:00-03:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2026-10-28',
            'tpEmit' => 1,
            'cMotivoEmisTI' => $motivoEmisTI,
            'finNFSe' => $finNfse,
            'cLocEmi' => '3550308',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'regTrib' => [
                    'opSimpNac' => 3,
                    'regApTribSN' => 1,
                    'regEspTrib' => 0,
                ],
            ],
            'toma' => [
                'CPF' => '11122233344',
                'xNome' => 'Tomador Exemplo',
            ],
            'serv' => [
                'locPrest' => ['cLocPrestacao' => '3550308'],
                'cServ' => [
                    'cTribNac' => '010701',
                    'xDescServ' => 'Hospedagem de sites',
                    'cNBS' => '115031000',
                ],
            ],
            'valores' => [
                'vServPrest' => ['vServ' => 100.00],
                'trib' => [
                    'tribMun.tribISSQN' => 1,
                    'tribMun.tpRetISSQN' => 1,
                    'totTrib.vTotTrib.vTotTribFed' => 0,
                    'totTrib.vTotTrib.vTotTribEst' => 0,
                    'totTrib.vTotTrib.vTotTribMun' => 0,
                ],
            ],
        ],
    ]);
}

it('writes the NT 009 layout when finNFSe is informed', function () {
    $xml = (new DpsXmlBuilder)->build(dpsLeiauteNt009('0'));

    expect($xml)->toContain('<tpEmit>1</tpEmit><finNFSe>0</finNFSe><cLocEmi>3550308</cLocEmi>')
        ->and($xml)->toContain('<cNBS>115031000</cNBS><xDescServ>Hospedagem de sites</xDescServ></cServ>');
});

it('writes finNFSe after cMotivoEmisTI', function () {
    $xml = (new DpsXmlBuilder)->build(dpsLeiauteNt009('0', '4'));

    expect($xml)->toContain('<tpEmit>1</tpEmit><cMotivoEmisTI>4</cMotivoEmisTI><finNFSe>0</finNFSe><cLocEmi>');
});

it('writes cServ in the 1.01 order even without finNFSe', function () {
    $xml = (new DpsXmlBuilder)->build(dpsLeiauteNt009(null));

    expect($xml)->not->toContain('finNFSe')
        ->and($xml)->toContain('<cNBS>115031000</cNBS><xDescServ>Hospedagem de sites</xDescServ></cServ>')
        ->and($xml)->not->toContain('<cAtvSN>');
});
