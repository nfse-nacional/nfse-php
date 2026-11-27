<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

it('grava vDedRed e gReeRepRes no pacote 20260209', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.01'],
        'infDPS' => [
            '@attributes' => ['Id' => IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001')],
            'tpAmb' => 1,
            'dhEmi' => '2026-11-26T10:00:00-03:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2026-11-26',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'prest' => [
                'CNPJ' => '12345678000199',
                'regTrib' => [
                    'opSimpNac' => 1,
                    'regEspTrib' => 0,
                ],
            ],
            'serv' => [
                'locPrest' => ['cLocPrestacao' => '3550308'],
                'cServ' => [
                    'cTribNac' => '010201',
                    'xDescServ' => 'Analise de sistemas',
                    'cNBS' => '115031000',
                ],
            ],
            'valores' => [
                'vServPrest' => ['vServ' => 100.00],
                'vDedRed' => ['vDR' => 10.00],
                'trib' => [
                    'tribMun' => [
                        'tribISSQN' => 1,
                        'tpRetISSQN' => 1,
                    ],
                    'totTrib' => ['indTotTrib' => 0],
                ],
            ],
            'IBSCBS' => [
                'finNFSe' => '0',
                'cIndOp' => '100301',
                'indDest' => 0,
                'valores' => [
                    'gReeRepRes' => [
                        'documentos' => [[
                            'docOutro' => [
                                'nDoc' => '123',
                                'xDoc' => 'Recibo',
                            ],
                            'dtEmiDoc' => '2026-02-01',
                            'dtCompDoc' => '2026-02-01',
                            'tpReeRepRes' => '01',
                            'vlrReeRepRes' => 10.00,
                        ]],
                    ],
                    'trib' => [
                        'CST' => '000',
                        'cClassTrib' => '000001',
                    ],
                ],
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder('20260209'))->build($dps);

    expect($xml)->toContain('<vDedRed><vDR>10.00</vDR></vDedRed>')
        ->and($xml)->toContain('<gReeRepRes><documentos><docOutro><nDoc>123</nDoc><xDoc>Recibo</xDoc></docOutro>')
        ->and($xml)->toContain('<xDescServ>Analise de sistemas</xDescServ><cNBS>115031000</cNBS>')
        ->and($xml)->toContain('<IBSCBS><finNFSe>0</finNFSe><cIndOp>100301</cIndOp><indDest>0</indDest>')
        ->and($xml)->toContain('<gIBSCBS><CST>000</CST><cClassTrib>000001</cClassTrib></gIBSCBS>')
        ->and($xml)->toContain('<tpEmit>1</tpEmit><cLocEmi>3550308</cLocEmi>')
        ->and($xml)->not->toContain('<vAjusteBC>')
        ->and($xml)->not->toContain('<bensMoveis>')
        ->and(validarContraSchema($xml, 'DPS_v1.01.xsd', '20260209'))->toBeTrue();
});
