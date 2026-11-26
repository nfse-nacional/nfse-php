<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

function dpsComIbscbs(array $ibscbs): DpsData
{
    return new DpsData([
        '@attributes' => ['versao' => '1.01'],
        'infDPS' => [
            '@attributes' => ['Id' => IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001')],
            'tpAmb' => 2,
            'dhEmi' => '2026-03-10T10:00:00-03:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2026-03-10',
            'tpEmit' => 1,
            'finNFSe' => '0',
            'cLocEmi' => '3550308',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Exemplo Ltda',
                'regTrib' => [
                    'opSimpNac' => 3,
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
                    'cTribNac' => '010201',
                    'xDescServ' => 'Analise de sistemas',
                    'cNBS' => '112011000',
                ],
            ],
            'valores' => [
                'vServPrest' => ['vServ' => 1000.00],
                'trib' => [
                    'tribMun.tribISSQN' => 1,
                    'tribMun.tpRetISSQN' => 1,
                    'tribMun.pAliq' => 5.00,
                    'totTrib.indTotTrib' => 0,
                ],
            ],
            'IBSCBS' => $ibscbs,
        ],
    ]);
}

it('builds a schema valid dps with the complete ibscbs group', function () {
    $dps = dpsComIbscbs([
        'indFinal' => 0,
        'cIndOp' => '010101',
        'tpOper' => 2,
        'gRefNFSe' => [
            'refNFSe' => [
                '12345678901234567890123456789012345678901234567890',
                '09876543210987654321098765432109876543210987654321',
            ],
        ],
        'tpEnteGov' => 1,
        'indDest' => 1,
        'dest' => [
            'CNPJ' => '98765432000188',
            'xNome' => 'Destinatario Exemplo Ltda',
            'end' => [
                'endNac' => [
                    'cMun' => '3550308',
                    'CEP' => '01001000',
                ],
                'xLgr' => 'Praca da Se',
                'nro' => '100',
                'xBairro' => 'Se',
            ],
            'email' => 'destinatario@exemplo.com.br',
        ],
        'imovel' => [
            'cMun' => '3550308',
            'gLocacao' => [
                'pCopropriedade' => 100,
                'vTotOper' => 1000,
            ],
            'gUnidImob' => [
                [
                    'inscImobFisc' => '1234567890',
                    'end' => [
                        'cep' => '01001000',
                        'xLgr' => 'Rua do Imovel',
                        'nro' => '200',
                        'xBairro' => 'Centro',
                    ],
                ],
            ],
        ],
        'bensMoveis' => [
            [
                'cNCMBemMovel' => '12345678',
                'xNCMBemMovel' => 'Equipamento locado',
                'qtdNCMBemMovel' => 1,
            ],
        ],
        'valores' => [
            'trib' => [
                'CST' => '200',
                'cClassTrib' => '200011',
                'gIBSCBS' => [
                    'cCredPres' => '01',
                    'gTribRegular' => [
                        'CSTReg' => '000',
                        'cClassTribReg' => '000001',
                    ],
                    'gDif' => [
                        'pDifUF' => 10.00,
                        'pDifMun' => 10.00,
                        'pDifCBS' => 5.00,
                    ],
                ],
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder)->build($dps);

    expect(validarContraSchema($xml, 'DPS_v1.01.xsd'))->toBeTrue()
        ->and($xml)->toContain('<cIndOp>010101</cIndOp>')
        ->and($xml)->toContain('<trib><CST>200</CST><cClassTrib>200011</cClassTrib><gIBSCBS>')
        ->and($xml)->toContain('<cMun>3550308</cMun>')
        ->and($xml)->toContain('<cNCMBemMovel>12345678</cNCMBemMovel>')
        ->and($xml)->toContain('<pDifCBS>5.00</pDifCBS>')
        ->and($xml)->not->toContain('<gReeRepRes>')
        ->and($xml)->not->toContain('<IBSCBS><finNFSe>');
});

it('builds a schema valid dps with the minimum ibscbs group', function () {
    $dps = dpsComIbscbs([
        'cIndOp' => '010101',
        'indDest' => 0,
        'valores' => [
            'trib' => [
                'CST' => '000',
                'cClassTrib' => '000001',
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder)->build($dps);

    expect(validarContraSchema($xml, 'DPS_v1.01.xsd'))->toBeTrue()
        ->and($xml)->toContain('<IBSCBS><cIndOp>010101</cIndOp><indDest>0</indDest>')
        ->and($xml)->toContain('<trib><CST>000</CST><cClassTrib>000001</cClassTrib></trib>')
        ->and($xml)->not()->toContain('<gRefNFSe>')
        ->and($xml)->not()->toContain('<dest>')
        ->and($xml)->not()->toContain('<imovel>')
        ->and($xml)->not()->toContain('<gIBSCBS>');
});

it('uses cCIB instead of the address when the property is registered', function () {
    $dps = dpsComIbscbs([
        'cIndOp' => '010101',
        'indDest' => 0,
        'imovel' => [
            'cMun' => '3550308',
            'gUnidImob' => [
                [
                    'cCIB' => '12345678',
                    'end' => [
                        'cep' => '01001000',
                        'xLgr' => 'Rua do Imovel',
                        'nro' => '200',
                        'xBairro' => 'Centro',
                    ],
                ],
            ],
        ],
        'valores' => [
            'trib' => [
                'CST' => '000',
                'cClassTrib' => '000001',
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder)->build($dps);

    expect(validarContraSchema($xml, 'DPS_v1.01.xsd'))->toBeTrue()
        ->and($xml)->toContain('<gUnidImob><cCIB>12345678</cCIB></gUnidImob>')
        ->and($xml)->not->toContain('Rua do Imovel');
});

it('ignores CST and cClassTrib left on the previous gIBSCBS path', function () {
    $dps = dpsComIbscbs([
        'cIndOp' => '010101',
        'indDest' => 0,
        'valores' => [
            'trib' => [
                'gIBSCBS' => [
                    'CST' => '000',
                    'cClassTrib' => '000001',
                ],
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder)->build($dps);

    expect($xml)->not->toContain('<CST>')
        ->and($xml)->not->toContain('<cClassTrib>');
});

it('writes a cIndOp that enters into force on 2026-12-01', function () {
    $dps = dpsComIbscbs([
        'cIndOp' => '020102',
        'indDest' => 0,
        'valores' => [
            'trib' => [
                'CST' => '000',
                'cClassTrib' => '000001',
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder)->build($dps);

    expect($xml)->toContain('<cIndOp>020102</cIndOp>');
});

it('keeps an unknown cIndOp in the xml', function () {
    $dps = dpsComIbscbs([
        'cIndOp' => '999999',
        'indDest' => 0,
        'valores' => [
            'trib' => [
                'CST' => '000',
                'cClassTrib' => '000001',
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder)->build($dps);

    expect($xml)->toContain('<cIndOp>999999</cIndOp>');
});

