<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

it('adds infoCompl element when informacoesComplementares is provided', function () {
    $id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

    $dpsData = \map(DPSData::class, [
        'versao' => '1.0',
        'infDPS' => [
            'id' => $id,
            'tpAmb' => '2',
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2023-10-27',
            'tpEmit' => '1',
            'cLocEmi' => '3550308',
            'prest' => [
                'CNPJ' => '12345678000199',
            ],
            'toma' => [
                'CPF' => '11122233344',
            ],
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '3550308',
                ],
                'cServ' => [
                    'cTribNac' => '010101',
                    'xDescServ' => 'Analise de sistemas',
                ],
                'infoCompl' => [
                    'idDocTec' => '1234567890',
                    'docRef' => '1234567890',
                    'xInfComp' => 'Informações adicionais',
                ],
                'cMotivoEmisTI' => '4',
            ],
            'valores' => [
                'vServPrest' => [
                    'vReceb' => '1000.00',
                    'vServ' => '1000.00',
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<infoCompl>')
        ->and($xml)->toContain('<xInfComp>Informações adicionais</xInfComp>')
        ->and($xml)->toContain('<idDocTec>')
        ->and($xml)->toContain('<docRef>');
});

it('does not add infoCompl element when descricaoInformacoesComplementares is null', function () {
    $id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

    $dpsData = \map(DPSData::class, [
        'versao' => '1.0',
        'infDPS' => [
            'id' => $id,
            'tpAmb' => '2',
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2023-10-27',
            'tpEmit' => '1',
            'cLocEmi' => '3550308',
            'prest' => [
                'CNPJ' => '12345678000199',
            ],
            'toma' => [
                'CPF' => '11122233344',
            ],
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '3550308',
                ],
                'cServ' => [
                    'cTribNac' => '010101',
                    'xDescServ' => 'Analise de sistemas',
                ],
                'cMotivoEmisTI' => '4',
            ],
            'valores' => [
                'vServPrest' => [
                    'vReceb' => '1000.00',
                    'vServ' => '1000.00',
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->not->toContain('<infoCompl>');
});
