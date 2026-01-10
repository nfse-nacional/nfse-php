<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Xml\DpsXmlBuilder;

it('can build xml with complex structures', function () {
    $dpsData = \map(DPSData::class, [
        'versao' => '1.0',
        'infDPS' => [
            'id' => 'DPS123',
            'tpAmb' => '2',
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => '1',
            'cLocEmi' => '3550308',
            'subst' => [
                'chSubstda' => '12345678901234567890123456789012345678901234',
                'cMotivo' => '01',
                'xMotivo' => 'Erro no valor',
            ],
            'prest' => [
                'CNPJ' => '12345678000199',
                'xNome' => 'Prestador',
            ],
            'toma' => [
                'CNPJ' => '12345678000199', // Added required toma
            ],
            'interm' => [
                'CNPJ' => '88888888000188',
                'xNome' => 'Intermediario',
                'end' => [
                    'xLgr' => 'Rua Inter',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                    'endNac' => [
                         'cMun' => '3550308',
                         'CEP' => '01001000',
                    ],
                ],
            ],
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '3550308',
                ],
                'cServ' => [
                    'cTribNac' => '010101',
                    'xDescServ' => 'Service',
                ],
                'comExt' => [
                    'mdPrest' => '1',
                    'vincPrest' => '1',
                    'tpPessoaExp' => '1',
                    'monExp' => 'USD',
                    'vServMonExp' => '100.00',
                ],
                'obra' => [
                    'inscImobFisc' => '123',
                    'cObra' => '456',
                    'end' => [
                        'xLgr' => 'Rua Obra',
                        'nro' => '200',
                        'xBairro' => 'Obra',
                        'endNac' => [
                             'cMun' => '3550308',
                             'CEP' => '01001000',
                        ],
                    ],
                ],
                'atvEvento' => [
                    'xNome' => 'Evento',
                    'dIni' => '2023-10-27',
                    'dFim' => '2023-10-28',
                    'id' => 'EVT123',
                ],
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => '100.0',
                    'vReceb' => '100.0',
                ],
                'vDescCondIncond' => [
                    'vDescIncond' => '10.0',
                    'vDescCond' => '5.0',
                ],
                'vDedRed' => [
                    'pDR' => '20.0',
                    'vDR' => '200.0',
                    'documentos' => [
                        [
                            'chNFSe' => '12345678901234567890123456789012345678901234',
                            'tpDedRed' => '1',
                            'vDedRedutivel' => '100.0',
                            'vDedRed' => '100.0',
                        ],
                    ],
                ],
                'trib' => [
                    'tribMun' => [
                        'tribISSQN' => '1',
                        'tpRetISSQN' => '1',
                    ],
                    'tribFed' => [
                        'piscofins' => [
                            'CST' => '01',
                            'vBCPisCofins' => '1000.0',
                            'pAliqPis' => '0.65',
                            'pAliqCofins' => '3.0',
                            'vPis' => '6.5',
                            'vCofins' => '30.0',
                            'tpRetPisCofins' => '1',
                        ],
                        'vRetIRRF' => '15.0',
                        'vRetCSLL' => '10.0',
                    ],
                    'totTrib' => [
                        'vTotTrib' => [
                             'vTotTribFed' => '50.0',
                             'vTotTribEst' => '20.0',
                             'vTotTribMun' => '30.0',
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<subst>')
        ->and($xml)->toContain('<chSubstda>12345678901234567890123456789012345678901234</chSubstda>')
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
    $dpsData = \map(DPSData::class, [
        'versao' => '1.0',
        'infDPS' => [
            'id' => 'DPS123',
            'tpAmb' => '2',
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => '1',
            'cLocEmi' => '3550308',
            'prest' => ['CNPJ' => '111'], // Required
            'toma' => ['CNPJ' => '222'], // Required
            'serv' => [
                'cServ' => ['cTribNac' => '0101'], // Required
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => '100.0',
                    'vReceb' => '100.0',
                ],
                'trib' => [
                    'tribMun' => [
                         'tribISSQN' => '1',
                         'tpRetISSQN' => '1',
                    ],
                    'totTrib' => [
                        'indTotTrib' => '1',
                    ],
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<indTotTrib>1</indTotTrib>');
});

it('can build xml with percentualTotalTributosSN', function () {
    $dpsData = \map(DPSData::class, [
        'versao' => '1.0',
        'infDPS' => [
            'id' => 'DPS123',
            'tpAmb' => '2',
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => '1',
            'cLocEmi' => '3550308',
            'prest' => ['CNPJ' => '111'],
            'toma' => ['CNPJ' => '222'],
            'serv' => ['cServ' => ['cTribNac' => '0101']],
            'valores' => [
                'vServPrest' => [
                    'vServ' => '100.0',
                    'vReceb' => '100.0',
                ],
                'trib' => [
                    'tribMun' => [
                        'tribISSQN' => '1',
                        'tpRetISSQN' => '1',
                    ],
                    'totTrib' => [
                        'pTotTribSN' => '5.0',
                    ],
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<pTotTribSN>5.00</pTotTribSN>');
});
