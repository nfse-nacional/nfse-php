<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Xml\DpsXmlBuilder;

it('serializes dps data to xml correctly', function () {
    DpsData::from([
        '@attributes' => ['versao' => '1.0'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'cMotivoEmisTI' => null,
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
                'end' => [
                    'endNac.cMun' => '3550308',
                    'endNac.CEP' => '01001000',
                    'xLgr' => 'Exemplo',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                    'xCpl' => 'Apto 1',
                    'endExt' => null,
                ],
                'fone' => '11999999999',
                'email' => 'prestador@example.com',
                'regTrib' => [
                    'opSimpNac' => 1,
                    'regApTribSN' => null,
                    'regEspTrib' => 0,
                ],
            ],
            'toma' => [
                'CPF' => '11122233344',
                'CNPJ' => null,
                'NIF' => null,
                'cNaoNIF' => null,
                'CAEPF' => null,
                'IM' => null,
                'xNome' => 'Tomador Exemplo',
                'end' => [
                    'endNac.cMun' => '3550308',
                    'endNac.CEP' => '01002000',
                    'xLgr' => 'Brasil',
                    'nro' => '200',
                    'xBairro' => 'Jardins',
                    'xCpl' => null,
                    'endExt' => null,
                ],
                'fone' => '11888888888',
                'email' => 'tomador@example.com',
            ],
            'interm' => null,
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '3550308',
                    'cPaisPrestacao' => 'BR',
                ],
                'cServ' => [
                    'cTribNac' => '1.01',
                    'cTribMun' => '1010',
                    'xDescServ' => 'Analise de sistemas',
                    'cNBS' => '1234',
                    'cIntContrib' => 'SERV001',
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
                'vDescCondIncond' => [
                    'vDescIncond' => 0.0,
                    'vDescCond' => 0.0,
                ],
                'vDedRed' => null,
                'trib' => [
                    'tribMun.tribISSQN' => 1,
                    'tribMun.tpImun' => null,
                    'tribMun.tpRetISSQN' => 1,
                    'tribMun.tpSusp' => null,
                    'tribMun.nProcesso' => null,
                    'tribMun.bm' => null,
                    'trib.cstPisCofins' => null,
                    'totTrib.pTotalTribSN' => null,
                    'totTrib.indTotTrib' => null,
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<DPS xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.0">')
        ->and($xml)->toContain('<infDPS Id="DPS123">')
        ->and($xml)->toContain('<tpAmb>2</tpAmb>')
        ->and($xml)->toContain('<CNPJ>12345678000199</CNPJ>')
        ->and($xml)->toContain('<vServ>1000.00</vServ>');
});
