<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Xml\DpsXmlBuilder;

it('can build xml with complex structures', function () {
    DpsData::from([
        '@versao' => '1.0',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'subst' => [
                'chSubstda' => '12345678901234567890123456789012345678901234',
                'cMotivo' => '01',
                'xMotivo' => 'Erro no valor',
            ],
            'prest' => [
                'CNPJ' => '12345678000199',
                'xNome' => 'Prestador',
                'regTrib' => [
                    'opSimpNac' => 1,
                    'regApTribSN' => 1,
                    'regEspTrib' => 1,
                ],
            ],
            'interm' => [
                'CNPJ' => '88888888000188',
                'xNome' => 'Intermediario',
                'end' => [
                    'xLgr' => 'Rua Inter',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                    'endNac.cMun' => '3550308',
                    'endNac.CEP' => '01001000',
                ],
            ],
            'serv' => [
                'comExt' => [
                    'mdPrest' => 1,
                    'vincPrest' => 1,
                    'tpPessoaExp' => 1,
                    'monExp' => 'USD',
                    'vServMonExp' => 100.00,
                ],
                'obra' => [
                    'inscImobFisc' => '123',
                    'cObra' => '456',
                    'end' => [
                        'xLgr' => 'Rua Obra',
                        'nro' => '200',
                        'xBairro' => 'Obra',
                        'endNac.cMun' => '3550308',
                        'endNac.CEP' => '01001000',
                    ],
                ],
                'atvEvento' => [
                    'xNome' => 'Evento',
                    'dIni' => '2023-10-27',
                    'dFim' => '2023-10-28',
                    'idAtividadeEvento' => 'EVT123',
                ],
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => 100.0,
                    'vReceb' => 100.0,
                ],
                'vDescCondIncond' => [
                    'vDescIncond' => 10.0,
                    'vDescCond' => 5.0,
                ],
                'vDedRed' => [
                    'pDR' => 20.0,
                    'vDR' => 200.0,
                    'documentos' => [
                        [
                            'chNFSe' => '12345678901234567890123456789012345678901234',
                            'tpDedRed' => 1,
                            'vDedRedutivel' => 100.0,
                            'vDedRed' => 100.0,
                        ],
                    ],
                ],
                'trib' => [
                    'tribMun.tribISSQN' => 1,
                    'tribMun.tpRetISSQN' => 1,
                    'tribFed.piscofins.CST' => '01',
                    'tribFed.piscofins.vBCPisCofins' => 1000.0,
                    'tribFed.piscofins.pAliqPis' => 0.65,
                    'tribFed.piscofins.pAliqCofins' => 3.0,
                    'tribFed.piscofins.vPis' => 6.5,
                    'tribFed.piscofins.vCofins' => 30.0,
                    'tribFed.piscofins.tpRetPisCofins' => 1,
                    'tribFed.vRetIRRF' => 15.0,
                    'tribFed.vRetCSLL' => 10.0,
                    'totTrib.vTotTrib.vTotTribFed' => 50.0,
                    'totTrib.vTotTrib.vTotTribEst' => 20.0,
                    'totTrib.vTotTrib.vTotTribMun' => 30.0,
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<subst>')
        ->and($xml)->toContain('<chSubstda>12345678901234567890123456789012345678901234</chSubstda>')
        ->and($xml)->toContain('<regTrib>')
        ->and($xml)->toContain('<interm>')
        ->and($xml)->toContain('<comExt>')
        ->and($xml)->toContain('<obra>')
        ->and($xml)->toContain('<atvEvento>')
        ->and($xml)->toContain('<vDescCondIncond>')
        ->and($xml)->toContain('<vDedRed>')
        ->and($xml)->toContain('<documentos>')
        ->and($xml)->toContain('<piscofins>')
        ->and($xml)->toContain('<vRetIRRF>15.00</vRetIRRF>')
        ->and($xml)->toContain('<vRetCSLL>10.00</vRetCSLL>')
        ->and($xml)->toContain('<vTotTribFed>50.00</vTotTribFed>');
});

it('can build xml with indicadorTotalTributos', function () {
    DpsData::from([
        '@versao' => '1.0',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'valores' => [
                'vServPrest' => [
                    'vServ' => 100.0,
                    'vReceb' => 100.0,
                ],
                'trib' => [
                    'tribMun.tribISSQN' => 1,
                    'totTrib.indTotTrib' => 1,
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<indTotTrib>1</indTotTrib>');
});

it('can build xml with percentualTotalTributosSN', function () {
    DpsData::from([
        '@versao' => '1.0',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'valores' => [
                'vServPrest' => [
                    'vServ' => 100.0,
                    'vReceb' => 100.0,
                ],
                'trib' => [
                    'tribMun.tribISSQN' => 1,
                    'totTrib.pTotTribSN' => 5.0,
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<pTotTribSN>5.00</pTotTribSN>');
});
