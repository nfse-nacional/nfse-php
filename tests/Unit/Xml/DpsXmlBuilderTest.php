<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

it('can build xml from dps data', function () {
    $id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

    $data = [
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
            'cMotivoEmisTI' => '4',
            'chNFSeRej' => '12345678901234567890123456789012345678901234',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Exemplo Ltda',
            ],
            'toma' => [
                'CPF' => '11122233344',
                'xNome' => 'Tomador Exemplo',
            ],
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '3550308',
                    'cPaisPrestacao' => 'BR',
                ],
                'cServ' => [
                    'cTribNac' => '010101',
                    'xDescServ' => 'Analise de sistemas',
                ],
            ],
            'valores' => [
                'vServPrest' => [
                    'vReceb' => '1000.00',
                    'vServ' => '1000.00',
                ],
                'trib' => [
                    'tribMun' => [
                        'tribISSQN' => '1',
                        'tpRetISSQN' => '1',
                        'exigSusp' => [
                            'tpSusp' => '1',
                            'nProcesso' => '123456',
                        ],
                        'BM' => [
                            'pRedBCBM' => '10.00',
                            'vRedBCBM' => '100.00',
                        ],
                    ],
                ]
            ],
        ],
        'versao' => '1.0'
    ];

    $dpsData = \map(DPSData::class, $data);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<DPS xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.0">')
        ->and($xml)->toContain('Id="'.$id.'"')
        ->and($xml)->toContain('<nDPS>1001</nDPS>')
        ->and($xml)->toContain('<vServ>1000.00</vServ>')
        ->and($xml)->toContain('<cMotivoEmisTI>4</cMotivoEmisTI>')
        ->and($xml)->toContain('<chNFSeRej>12345678901234567890123456789012345678901234</chNFSeRej>')
        ->and($xml)->toContain('<tpSusp>1</tpSusp>')
        ->and($xml)->toContain('<nProcesso>123456</nProcesso>')
        ->and($xml)->toContain('<pRedBCBM>10.00</pRedBCBM>')
        ->and($xml)->toContain('<vRedBCBM>100.00</vRedBCBM>')
        ->and($xml)->not()->toContain('<idDocTec></idDocTec>')
        ->and($xml)->not()->toContain('<docRef></docRef>')
        ->and($xml)->not()->toContain('<xInfComp></xInfComp>');
});

it('can build xml with pAliq and correct tribMun order', function () {
    $id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

    $data = [
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
            'cMotivoEmisTI' => '4',
            'prest' => [
                'CNPJ' => '12345678000199',
            ],
            'toma' => [
                'CPF' => '11122233344',
            ],
            'serv' => [
                'cServ' => [
                    'cTribNac' => '010101',
                ],
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => '1000.00',
                ],
                'trib' => [
                    'tribMun' => [
                        'tribISSQN' => '1',
                        'tpImunidade' => '0',
                        'tpRetISSQN' => '1',
                        'pAliq' => '5.00',
                        'exigSusp' => [
                            'tpSusp' => '1',
                            'nProcesso' => '123456',
                        ],
                        'BM' => [
                            'pRedBCBM' => '10.0',
                            'vRedBCBM' => '100.0',
                        ],
                    ],
                ],
            ],
        ],
        'versao' => '1.0'
    ];

    $dpsData = \map(DPSData::class, $data);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<pAliq>5.00</pAliq>');

    // Check order: tribISSQN -> tpImunidade -> exigSusp -> BM -> tpRetISSQN -> pAliq
    $tribIssqnPos = strpos($xml, '<tribISSQN>1</tribISSQN>');
    $tpImunidadePos = strpos($xml, '<tpImunidade>0</tpImunidade>');
    $exigSuspPos = strpos($xml, '<exigSusp>');
    $bmPos = strpos($xml, '<BM>');
    $tpRetIssqnPos = strpos($xml, '<tpRetISSQN>1</tpRetISSQN>');
    $pAliqPos = strpos($xml, '<pAliq>5.00</pAliq>');

    expect($tribIssqnPos)->toBeLessThan($tpImunidadePos, 'tribISSQN should occur before tpImunidade')
        ->and($tpImunidadePos)->toBeLessThan($exigSuspPos, 'tpImunidade should occur before exigSusp')
        ->and($exigSuspPos)->toBeLessThan($bmPos, 'exigSusp should occur before BM')
        ->and($bmPos)->toBeLessThan($tpRetIssqnPos, 'BM should occur before tpRetISSQN')
        ->and($tpRetIssqnPos)->toBeLessThan($pAliqPos, 'tpRetISSQN should occur before pAliq');
});
