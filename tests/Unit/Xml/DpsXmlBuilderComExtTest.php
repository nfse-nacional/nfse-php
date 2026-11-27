<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\DpsXmlBuilder;

function dpsComComercioExterior(float $valorServicoMoeda): DpsData
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
                'regTrib' => [
                    'opSimpNac' => 3,
                    'regApTribSN' => 1,
                    'regEspTrib' => 0,
                ],
            ],
            'toma' => [
                'cNaoNIF' => '2',
                'xNome' => 'Acme Inc',
                'end' => [
                    'endExt' => [
                        'cPais' => 'US',
                        'cEndPost' => '94105',
                        'xCidade' => 'San Francisco',
                        'xEstProvReg' => 'CA',
                    ],
                    'xLgr' => 'Market Street',
                    'nro' => '500',
                    'xBairro' => 'Centro',
                ],
            ],
            'serv' => [
                'locPrest' => ['cLocPrestacao' => '3550308'],
                'cServ' => [
                    'cTribNac' => '010701',
                    'xDescServ' => 'Hospedagem de sites',
                    'cNBS' => '115031000',
                ],
                'comExt' => [
                    'mdPrestacao' => '1',
                    'vincPrest' => '0',
                    'tpMoeda' => '220',
                    'vServMoeda' => $valorServicoMoeda,
                    'mecAFComexP' => '01',
                    'mecAFComexT' => '01',
                    'movTempBens' => '1',
                    'mdic' => '0',
                ],
            ],
            'valores' => [
                'vServPrest' => ['vServ' => 500.00],
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

it('writes vServMoeda with two decimal places', function (float $valor, string $esperado) {
    $xml = (new DpsXmlBuilder('20261020'))->build(dpsComComercioExterior($valor));

    expect($xml)->toContain("<vServMoeda>{$esperado}</vServMoeda>")
        ->and(validarContraSchema($xml, 'DPS_v1.01.xsd'))->toBeTrue();
})->with([
    'centavos terminados em zero' => [99.9, '99.90'],
    'valor inteiro' => [250.0, '250.00'],
    'centavos' => [10.05, '10.05'],
]);
