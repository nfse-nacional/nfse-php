<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

it('adds infoCompl element when informacoesComplementares is provided', function () {
    $id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

    DpsData::from([
        '@attributes' => ['versao' => '1.0'],
        'infDPS' => [
            '@attributes' => ['Id' => $id],
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'cMotivoEmisTI' => '4',
            'chNFSeRej' => null,
            'subst' => null,
            'prest' => [
                'CNPJ' => '12345678000199',
                'CPF' => null,
                'NIF' => null,
                'cNaoNIF' => null,
                'CAEPF' => null,
                'IM' => '12345',
                'xNome' => 'Prestador Exemplo Ltda',
                'end' => null,
                'fone' => null,
                'email' => null,
                'regTrib' => null,
            ],
            'toma' => [
                'CPF' => '11122233344',
                'CNPJ' => null,
                'NIF' => null,
                'cNaoNIF' => null,
                'CAEPF' => null,
                'IM' => null,
                'xNome' => 'Tomador Exemplo',
                'end' => null,
                'fone' => null,
                'email' => null,
            ],
            'interm' => null,
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '3550308',
                    'cPaisPrestacao' => 'BR',
                ],
                'cServ' => [
                    'cTribNac' => '1.01',
                    'cTribMun' => null,
                    'xDescServ' => 'Analise de sistemas',
                    'cNBS' => null,
                    'cIntContrib' => null,
                ],
                'comExt' => null,
                'obra' => null,
                'atvEvento' => null,
                'infoCompl' => [
                    'idDocTec' => '1234567890',
                    'docRef' => '1234567890',
                    'xInfComp' => 'Informações adicionais',
                ],
            ],
            'valores' => [
                'vServPrest' => [
                    'vReceb' => 1000.00,
                    'vServ' => 1000.00,
                ],
                'vDescCondIncond' => null,
                'vDedRed' => null,
                'trib' => [],
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

    DpsData::from([
        '@attributes' => ['versao' => '1.0'],
        'infDPS' => [
            '@attributes' => ['Id' => $id],
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'cMotivoEmisTI' => '4',
            'chNFSeRej' => null,
            'subst' => null,
            'prest' => [
                'CNPJ' => '12345678000199',
                'CPF' => null,
                'NIF' => null,
                'cNaoNIF' => null,
                'CAEPF' => null,
                'IM' => '12345',
                'xNome' => 'Prestador Exemplo Ltda',
                'end' => null,
                'fone' => null,
                'email' => null,
                'regTrib' => null,
            ],
            'toma' => [
                'CPF' => '11122233344',
                'CNPJ' => null,
                'NIF' => null,
                'cNaoNIF' => null,
                'CAEPF' => null,
                'IM' => null,
                'xNome' => 'Tomador Exemplo',
                'end' => null,
                'fone' => null,
                'email' => null,
            ],
            'interm' => null,
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '3550308',
                    'cPaisPrestacao' => 'BR',
                ],
                'cServ' => [
                    'cTribNac' => '1.01',
                    'cTribMun' => null,
                    'xDescServ' => 'Analise de sistemas',
                    'cNBS' => null,
                    'cIntContrib' => null,
                ],
                'comExt' => null,
                'obra' => null,
                'atvEvento' => null,
            ],
            'valores' => [
                'vServPrest' => [
                    'vReceb' => 1000.00,
                    'vServ' => 1000.00,
                ],
                'vDescCondIncond' => null,
                'vDedRed' => null,
                'trib' => [],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->not->toContain('<infoCompl>');
});
