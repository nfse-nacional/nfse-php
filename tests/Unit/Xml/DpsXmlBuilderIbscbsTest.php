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
        'finNFSe' => '0',
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
            'inscImobFisc' => '1234567890',
            'end' => [
                'cep' => '01001000',
                'xLgr' => 'Rua do Imovel',
                'nro' => '200',
                'xBairro' => 'Centro',
            ],
        ],
        'valores' => [
            'gReeRepRes' => [
                'documentos' => [
                    [
                        'dFeNacional' => [
                            'tipoChaveDFe' => 1,
                            'chaveDFe' => '12345678901234567890123456789012345678901234567890',
                        ],
                        'fornec' => [
                            'CNPJ' => '11222333000144',
                            'xNome' => 'Fornecedor Exemplo Ltda',
                        ],
                        'dtEmiDoc' => '2026-02-10',
                        'dtCompDoc' => '2026-02-01',
                        'tpReeRepRes' => '01',
                        'vlrReeRepRes' => 150.00,
                    ],
                    [
                        'docOutro' => [
                            'nDoc' => '55',
                            'xDoc' => 'Recibo de despesa',
                        ],
                        'dtEmiDoc' => '2026-02-15',
                        'dtCompDoc' => '2026-02-15',
                        'tpReeRepRes' => '99',
                        'xTpReeRepRes' => 'Reembolso de despesa por conta e ordem',
                        'vlrReeRepRes' => 50.00,
                    ],
                ],
            ],
            'trib' => [
                'gIBSCBS' => [
                    'CST' => '200',
                    'cClassTrib' => '200011',
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
        ->and($xml)->toContain('<cClassTrib>200011</cClassTrib>')
        ->and($xml)->toContain('<xTpReeRepRes>Reembolso de despesa por conta e ordem</xTpReeRepRes>')
        ->and($xml)->toContain('<vlrReeRepRes>150.00</vlrReeRepRes>')
        ->and($xml)->toContain('<pDifCBS>5.00</pDifCBS>');
});

it('builds a schema valid dps with the minimum ibscbs group', function () {
    $dps = dpsComIbscbs([
        'finNFSe' => '0',
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

    expect(validarContraSchema($xml, 'DPS_v1.01.xsd'))->toBeTrue()
        ->and($xml)->toContain('<IBSCBS><finNFSe>0</finNFSe><cIndOp>010101</cIndOp><indDest>0</indDest>')
        ->and($xml)->toContain('<gIBSCBS><CST>000</CST><cClassTrib>000001</cClassTrib></gIBSCBS>')
        ->and($xml)->not()->toContain('<gRefNFSe>')
        ->and($xml)->not()->toContain('<dest>')
        ->and($xml)->not()->toContain('<imovel>')
        ->and($xml)->not()->toContain('<gDif>');
});

it('uses cCIB instead of the address when the property is registered', function () {
    $dps = dpsComIbscbs([
        'finNFSe' => '0',
        'cIndOp' => '010101',
        'indDest' => 0,
        'imovel' => [
            'cCIB' => '12345678',
            'end' => [
                'cep' => '01001000',
                'xLgr' => 'Rua do Imovel',
                'nro' => '200',
                'xBairro' => 'Centro',
            ],
        ],
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

    expect(validarContraSchema($xml, 'DPS_v1.01.xsd'))->toBeTrue()
        ->and($xml)->toContain('<imovel><cCIB>12345678</cCIB></imovel>');
});
