<?php

namespace Nfse\Tests\Unit\Dto;

use Nfse\Dto\Nfse\NfseData;
use Nfse\Support\IdGenerator;
use Nfse\Xml\NfseXmlBuilder;

it('can generate XML with all fields from ExemploPisZeradoCofinsSobreFaturamentoPreenchido', function () {
    $dpsId = IdGenerator::generateDpsId('11905971000105', '3304557', '333', '6');

    // Construct the DTO based on the XML example
    $nfse = new NfseData([
        '@attributes' => ['versao' => '1.01'],
        'infNFSe' => [
            '@attributes' => ['Id' => 'NFS33045572211905971000105000000000014625124504258429'],
            'nNFSe' => '146',
            'nDFSe' => '60631',
            'dhProc' => '2025-12-30T19:01:35-03:00',
            'ambGer' => 2,
            'verAplic' => 'SefinNac_Pre_1.4.0',
            'procEmi' => 1,
            'xLocEmi' => 'Rio de Janeiro',
            'xLocPrestacao' => 'Rio de Janeiro',
            'cLocIncid' => '3304557',
            'xLocIncid' => 'Rio de Janeiro',
            'xTribNac' => 'Análise e desenvolvimento de sistemas.',
            'xTribMun' => 'Análise de sistemas.',
            'xNBS' => 'Serviços de projeto, desenvolvimento e instalação de aplicativos e programas não personalizados (não customizados)',
            'tpEmis' => 1,
            'cStat' => 100,
            'DPS' => [
                '@attributes' => ['versao' => '1.01'],
                'infDPS' => [
                    '@attributes' => ['Id' => $dpsId],
                    'tpAmb' => 2,
                    'dhEmi' => '2025-12-30T19:00:06-03:00',
                    'verAplic' => 'MXM.RTC-1.00',
                    'serie' => '333',
                    'nDPS' => '6',
                    'dCompet' => '2025-12-30',
                    'tpEmit' => 1,
                    'cLocEmi' => '3304557',
                    'prest' => [
                        'CNPJ' => '11905971000105',
                        'fone' => '3132332300',
                        'email' => 'sau@mxm.com.br',
                        'regTrib' => [
                            'opSimpNac' => 3,
                            'regApTribSN' => 2,
                            'regEspTrib' => 0,
                        ],
                    ],
                    'toma' => [
                        'CNPJ' => '39847728000199',
                        'xNome' => 'MXM & JETTAX',
                        'end' => [
                            'endNac.cMun' => '3303302',
                            'endNac.CEP' => '24020077',
                            'xLgr' => 'AV RIO BRANCO',
                            'nro' => '123',
                            'xBairro' => 'CENTRO',
                        ],
                        'fone' => '2132332300',
                        'email' => 'SAU@mxm.com.br',
                    ],
                    'serv' => [
                        'locPrest' => [
                            'cLocPrestacao' => '3304557',
                        ],
                        'cServ' => [
                            'cTribNac' => '010101',
                            'cTribMun' => '001',
                            'xDescServ' => 'Analise e desenvolvimento de sistemas (MXM)',
                            'cNBS' => '115021000',
                        ],
                    ],
                    'valores' => [
                        'vServPrest' => [
                            'vServ' => 10000.00,
                        ],
                        'trib' => [
                            'tribMun.tribISSQN' => 1,
                            'tribMun.tpRetISSQN' => 1,
                            'tribFed.piscofins.CST' => '01',
                            'tribFed.piscofins.vBCPisCofins' => 10000.00,
                            'tribFed.piscofins.pAliqPis' => 0.00,
                            'tribFed.piscofins.pAliqCofins' => 7.60,
                            'tribFed.piscofins.vPis' => 0.00,
                            'tribFed.piscofins.vCofins' => 760.00,
                            'tribFed.piscofins.tpRetPisCofins' => 2,
                            'tribFed.vRetIRRF' => 150.00,
                            'tribFed.vRetCSLL' => 465.00,
                            'totTrib.vTotTrib.vTotTribFed' => 760.00,
                            'totTrib.vTotTrib.vTotTribEst' => 0.00,
                            'totTrib.vTotTrib.vTotTribMun' => 500.00,
                        ],
                    ],
                ],
            ],
            'emit' => [
                'CNPJ' => '11905971000105',
                'xNome' => 'GUIDI SISTEMAS E SERVICOS EM TECNOLOGIA DA INFORMACAO LTDA',
                'enderNac' => [
                    'xLgr' => 'GUANDU DO SAPE',
                    'nro' => '01450',
                    'xBairro' => 'CAMPO GRANDE',
                    'cMun' => '3304557',
                    'UF' => 'RJ',
                    'CEP' => '23095072',
                ],
                'fone' => '2135933387',
                'email' => 'VANDERSON@GUIDISISTEMAS.COM.BR',
            ],
            'valores' => [
                'vBC' => 10000.00,
                'pAliqAplic' => 5.00,
                'vISSQN' => 500.00,
                'vTotalRet' => 615.00,
                'vLiq' => 9385.00,
            ],
        ],
    ]);

    $builder = new NfseXmlBuilder('20261020');
    $xml = $builder->build($nfse);

    // Assertions for NFSe fields
    expect($xml)->toContain('Id="NFS33045572211905971000105000000000014625124504258429"')
        ->and($xml)->toContain('<xLocEmi>Rio de Janeiro</xLocEmi>')
        ->and($xml)->toContain('<xLocPrestacao>Rio de Janeiro</xLocPrestacao>')
        ->and($xml)->toContain('<nNFSe>146</nNFSe>')
        ->and($xml)->toContain('<cLocIncid>3304557</cLocIncid>')
        ->and($xml)->toContain('<xLocIncid>Rio de Janeiro</xLocIncid>')
        ->and($xml)->toContain('<xTribNac>Análise e desenvolvimento de sistemas.</xTribNac>')
        ->and($xml)->toContain('<xTribMun>Análise de sistemas.</xTribMun>')
        ->and($xml)->toContain('<xNBS>Serviços de projeto, desenvolvimento e instalação de aplicativos e programas não personalizados (não customizados)</xNBS>')
        ->and($xml)->toContain('<verAplic>SefinNac_Pre_1.4.0</verAplic>')
        ->and($xml)->toContain('<ambGer>2</ambGer>')
        ->and($xml)->toContain('<tpEmis>1</tpEmis>')
        ->and($xml)->toContain('<procEmi>1</procEmi>')
        ->and($xml)->toContain('<cStat>100</cStat>')
        ->and($xml)->toContain('<dhProc>2025-12-30T19:01:35-03:00</dhProc>')
        ->and($xml)->toContain('<nDFSe>60631</nDFSe>');

    // Assertions for Emitente
    expect($xml)->toContain('<CNPJ>11905971000105</CNPJ>')
        ->and($xml)->toContain('<xNome>GUIDI SISTEMAS E SERVICOS EM TECNOLOGIA DA INFORMACAO LTDA</xNome>')
        ->and($xml)->toContain('<xLgr>GUANDU DO SAPE</xLgr>')
        ->and($xml)->toContain('<nro>01450</nro>')
        ->and($xml)->toContain('<xBairro>CAMPO GRANDE</xBairro>')
        ->and($xml)->toContain('<cMun>3304557</cMun>')
        ->and($xml)->toContain('<UF>RJ</UF>')
        ->and($xml)->toContain('<CEP>23095072</CEP>')
        ->and($xml)->toContain('<fone>2135933387</fone>')
        ->and($xml)->toContain('<email>VANDERSON@GUIDISISTEMAS.COM.BR</email>');

    // Assertions for Valores NFSe
    expect($xml)->toContain('<vBC>10000.00</vBC>')
        ->and($xml)->toContain('<pAliqAplic>5.00</pAliqAplic>')
        ->and($xml)->toContain('<vISSQN>500.00</vISSQN>')
        ->and($xml)->toContain('<vTotalRet>615.00</vTotalRet>')
        ->and($xml)->toContain('<vLiq>9385.00</vLiq>');

    // Assertions for DPS fields
    expect($xml)->toContain('Id="'.$dpsId.'"')
        ->and($xml)->toContain('<tpAmb>2</tpAmb>')
        ->and($xml)->toContain('<dhEmi>2025-12-30T19:00:06-03:00</dhEmi>')
        ->and($xml)->toContain('<verAplic>MXM.RTC-1.00</verAplic>')
        ->and($xml)->toContain('<serie>333</serie>')
        ->and($xml)->toContain('<nDPS>6</nDPS>')
        ->and($xml)->toContain('<dCompet>2025-12-30</dCompet>')
        ->and($xml)->toContain('<tpEmit>1</tpEmit>')
        ->and($xml)->toContain('<cLocEmi>3304557</cLocEmi>');

    // Assertions for Prestador
    expect($xml)->toContain('<CNPJ>11905971000105</CNPJ>')
        ->and($xml)->toContain('<fone>3132332300</fone>')
        ->and($xml)->toContain('<email>sau@mxm.com.br</email>')
        ->and($xml)->toContain('<opSimpNac>3</opSimpNac>')
        ->and($xml)->toContain('<regApTribSN>2</regApTribSN>')
        ->and($xml)->toContain('<regEspTrib>0</regEspTrib>');

    // Assertions for Tomador
    expect($xml)->toContain('<CNPJ>39847728000199</CNPJ>')
        ->and($xml)->toContain('<xNome>MXM &amp; JETTAX</xNome>')
        ->and($xml)->toContain('<cMun>3303302</cMun>')
        ->and($xml)->toContain('<CEP>24020077</CEP>')
        ->and($xml)->toContain('<xLgr>AV RIO BRANCO</xLgr>')
        ->and($xml)->toContain('<nro>123</nro>')
        ->and($xml)->toContain('<xBairro>CENTRO</xBairro>')
        ->and($xml)->toContain('<fone>2132332300</fone>')
        ->and($xml)->toContain('<email>SAU@mxm.com.br</email>');

    // Assertions for Servico
    expect($xml)->toContain('<cLocPrestacao>3304557</cLocPrestacao>')
        ->and($xml)->toContain('<cTribNac>010101</cTribNac>')
        ->and($xml)->toContain('<cTribMun>001</cTribMun>')
        ->and($xml)->toContain('<xDescServ>Analise e desenvolvimento de sistemas (MXM)</xDescServ>')
        ->and($xml)->toContain('<cNBS>115021000</cNBS>');

    // Assertions for Valores DPS
    expect($xml)->toContain('<vServ>10000.00</vServ>')
        ->and($xml)->toContain('<tribISSQN>1</tribISSQN>')
        ->and($xml)->toContain('<tpRetISSQN>1</tpRetISSQN>')
        ->and($xml)->toContain('<CST>01</CST>')
        ->and($xml)->toContain('<vBCPisCofins>10000.00</vBCPisCofins>')
        ->and($xml)->toContain('<pAliqPis>0.00</pAliqPis>')
        ->and($xml)->toContain('<pAliqCofins>7.60</pAliqCofins>')
        ->and($xml)->toContain('<vPis>0.00</vPis>')
        ->and($xml)->toContain('<vCofins>760.00</vCofins>')
        ->and($xml)->toContain('<tpRetPisCofins>2</tpRetPisCofins>')
        ->and($xml)->toContain('<vRetIRRF>150.00</vRetIRRF>')
        ->and($xml)->toContain('<vRetCSLL>465.00</vRetCSLL>')
        ->and($xml)->toContain('<vTotTribFed>760.00</vTotTribFed>')
        ->and($xml)->toContain('<vTotTribEst>0.00</vTotTribEst>')
        ->and($xml)->toContain('<vTotTribMun>500.00</vTotTribMun>');
});
