<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

function dpsSchema20261124(array $infDps = []): DpsData
{
    return new DpsData([
        '@attributes' => ['versao' => '1.01'],
        'infDPS' => array_replace([
            '@attributes' => ['Id' => IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001')],
            'tpAmb' => 2,
            'dhEmi' => '2026-11-26T10:00:00-03:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2026-11-26',
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
                'end' => [
                    'endNac' => [
                        'cMun' => '3550308',
                        'CEP' => '01001000',
                    ],
                    'xLgr' => 'Rua do Tomador',
                    'nro' => '10',
                    'xBairro' => 'Centro',
                ],
            ],
            'indDest' => 0,
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
        ], $infDps),
    ]);
}

it('grava indDest em infDPS no schema 20261124 mesmo sem IBS CBS', function () {
    $dps = dpsSchema20261124();
    $xml = (new DpsXmlBuilder('20261124'))->build($dps);

    expect($xml)->toContain('</toma><indDest>0</indDest><serv>')
        ->and($xml)->not->toContain('<IBSCBS>')
        ->and(validarContraSchema($xml, 'DPS_v1.01.xsd', '20261124'))->toBeTrue();

    $xmlAtual = (new DpsXmlBuilder('20261020'))->build($dps);

    expect($xmlAtual)->not->toContain('<indDest>');
});

it('tira indDest e dest de IBSCBS no schema 20261124', function () {
    $dps = dpsSchema20261124([
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
        ],
        'IBSCBS' => [
            'cIndOp' => '010101',
            'indDest' => 1,
            'dest' => [
                'CNPJ' => '98765432000188',
                'xNome' => 'Destinatario Exemplo Ltda',
            ],
            'valores' => [
                'trib' => [
                    'CST' => '000',
                    'cClassTrib' => '000001',
                ],
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder('20261124'))->build($dps);

    expect($xml)->toContain('</toma><indDest>1</indDest><dest><CNPJ>98765432000188</CNPJ>')
        ->and($xml)->toContain('<IBSCBS><cIndOp>010101</cIndOp><valores>')
        ->and($xml)->not->toContain('<IBSCBS><cIndOp>010101</cIndOp><indDest>')
        ->and(validarContraSchema($xml, 'DPS_v1.01.xsd', '20261124'))->toBeTrue();
});

it('grava o comercio exterior do schema 20261124 sem os campos antigos', function () {
    $dps = dpsSchema20261124([
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '010701',
                'xDescServ' => 'Hospedagem de sites',
                'cNBS' => '115031000',
            ],
            'comExt' => [
                'mdPrestacao' => '5',
                'vincPrest' => '0',
                'tpMoeda' => '220',
                'nFatura' => '12345',
                'vFatura' => 10.5,
                'mecAFComexP' => '01',
                'mecAFComexT' => '01',
                'movTempBens' => '1',
                'nDUIMP' => '123456789012345',
                'nDUE' => '12345678901234',
                'mdic' => '0',
                'nContCambio' => '98765',
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder('20261124'))->build($dps);

    expect($xml)->toContain('<nFatura>12345</nFatura><vFatura>10.50</vFatura>')
        ->and($xml)->toContain('<nDUIMP>123456789012345</nDUIMP><nDUE>12345678901234</nDUE>')
        ->and($xml)->toContain('<nContCambio>98765</nContCambio>')
        ->and($xml)->toContain('<mdPrestacao>5</mdPrestacao>')
        ->and($xml)->not->toContain('<vServMoeda>')
        ->and($xml)->not->toContain('<nDI>')
        ->and($xml)->not->toContain('<nRE>')
        ->and(validarContraSchema($xml, 'DPS_v1.01.xsd', '20261124'))->toBeTrue();
});

it('grava cMun do evento e o ajuste de base do comercio exterior no schema 20261124', function () {
    $dps = dpsSchema20261124([
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '010201',
                'xDescServ' => 'Analise de sistemas',
                'cNBS' => '112011000',
            ],
            'atvEvento' => [
                'xNome' => 'Feira de servicos',
                'dtIni' => '2026-11-26',
                'dtFim' => '2026-11-27',
                'cMun' => '3550308',
                'idAtvEvt' => 'EVT1',
            ],
        ],
        'valores' => [
            'vServPrest' => ['vServ' => 1000.00],
            'vAjusteBC' => [
                'pAjusteBCISSQN' => 1.5,
                'vAjusteBCIBSCBSComExt' => -2.5,
            ],
            'trib' => [
                'tribMun.tribISSQN' => 1,
                'tribMun.tpRetISSQN' => 1,
                'tribMun.pAliq' => 5.00,
                'totTrib.indTotTrib' => 0,
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder('20261124'))->build($dps);

    expect($xml)->toContain('<dtFim>2026-11-27</dtFim><cMun>3550308</cMun><idAtvEvt>EVT1</idAtvEvt>')
        ->and($xml)->toContain('<pAjusteBCISSQN>1.50</pAjusteBCISSQN><vAjusteBCIBSCBSComExt>-2.50</vAjusteBCIBSCBSComExt>')
        ->and(validarContraSchema($xml, 'DPS_v1.01.xsd', '20261124'))->toBeTrue();
});

it('grava condominios no schema 20261124 depois de bensMoveis', function () {
    $dps = dpsSchema20261124([
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '990501',
                'xDescServ' => 'Administracao de condominio',
                'cNBS' => '112011000',
            ],
        ],
        'IBSCBS' => [
            'cIndOp' => '010101',
            'bensMoveis' => [
                [
                    'cNCMBemMovel' => '12345678',
                    'xNCMBemMovel' => 'Equipamento locado',
                    'qtdNCMBemMovel' => 1,
                ],
            ],
            'condominios' => [
                'dVencOrig' => '2026-11-26',
                'gCobranca' => [
                    [
                        'tpCobranca' => '99',
                        'xTpCobranca' => 'Taxa de obra',
                        'vCobranca' => 800.5,
                        'gDetCobranca' => [
                            [
                                'tpDetCobranca' => '999',
                                'xTpDetCobranca' => 'Reforma da fachada',
                                'vDetCobranca' => 800.5,
                            ],
                        ],
                    ],
                ],
                'gDesconto' => [
                    [
                        'tpDesconto' => '1',
                        'vDesconto' => 50,
                        'xTpDesconto' => 'Pontualidade',
                    ],
                ],
            ],
            'valores' => [
                'trib' => [
                    'CST' => '000',
                    'cClassTrib' => '000001',
                ],
            ],
        ],
    ]);

    $xml = (new DpsXmlBuilder('20261124'))->build($dps);

    expect($xml)->toContain('</bensMoveis><condominios><dVencOrig>2026-11-26</dVencOrig>')
        ->and($xml)->toContain('<tpCobranca>99</tpCobranca><xTpCobranca>Taxa de obra</xTpCobranca><vCobranca>800.50</vCobranca>')
        ->and($xml)->toContain('<tpDetCobranca>999</tpDetCobranca><xTpDetCobranca>Reforma da fachada</xTpDetCobranca><vDetCobranca>800.50</vDetCobranca>')
        ->and($xml)->toContain('<tpDesconto>1</tpDesconto><vDesconto>50.00</vDesconto><xTpDesconto>Pontualidade</xTpDesconto>')
        ->and($xml)->toContain('</condominios><valores>')
        ->and(validarContraSchema($xml, 'DPS_v1.01.xsd', '20261124'))->toBeTrue();

    $xmlAtual = (new DpsXmlBuilder('20261020'))->build($dps);

    expect($xmlAtual)->not->toContain('<condominios>');
});
