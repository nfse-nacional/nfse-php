<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Xml\DpsXmlBuilder;

it('can build xml matching ExemploPrestadorPessoaFisica', function () {
    $dpsData = map(DPSData::class, [
        'versao' => '1.00',
        'infDPS' => [
            // '@attributes' removed as Valinor doesn't map them by default unless mapped to a property
            // Assuming the DTO structure matches the array keys or has Source attributes
            // 'Id' needs to be checked if it's in the DTO
            'id' => 'DPS231400310000667299238300001000000000000046', 
            'tpAmb' => 1,
            'dhEmi' => '2025-12-15T11:11:09-03:00',
            'verAplic' => 'Sistema NFS-e',
            'serie' => '00001',
            'nDPS' => '46',
            'dCompet' => '2025-12-15',
            'tpEmit' => 1,
            'cLocEmi' => '2314003',
            'prest' => [
                'CPF' => '06672992383',
                'email' => 'naoinformado@gmail.com',
                'regTrib' => [
                    'opSimpNac' => 1,
                    'regEspTrib' => 0,
                ],
            ],
            'toma' => [
                'CNPJ' => '10237604000100',
                'xNome' => 'FUNDO MUNICIPAL DE SAUDE - VARZEA ALEGRE',
                'end' => [
                    'endNac' => [ // Nested structure update might be needed if flat keys don't work
                         'cMun' => '2314003',
                         'CEP' => '63540000',
                    ],
                    'xLgr' => 'RUA DEP LUIZ OTACILIO CORREIA',
                    'nro' => '-',
                    'xBairro' => 'CENTRO',
                ],
            ],
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => '2314003',
                ],
                'cServ' => [
                    'cTribNac' => '040601',
                    'xDescServ' => '(VALOR EMPENHADO PARA ATENDER DESPESAS COM CREDENCIAMENTO DE PROFISSIONAIS ESPECIALIZADOS COMO  TECNICA DE ENFERMAGEM PARA COMPLEMENTAR A EQUIPE DE ATENÇÃO DOMICILIAR (EMAD) E A EQUIPE MULTIPROFISSIONAL  DE APOIO (EMAP), NO ÂMBITO DO SISTEMA ÚNICO DE SAÚDE (SUS), CONFORME TERMO DE REFERÊNCIA, A SEREM PRESTADOS  NESTA CIDADE, ATRAVÉS DA SECRETARIA MUNICIPAL DE SAÚDE DE VÁRZEA ALEGRE/CE,CONFORME PROCESSO DE Nº003-2024 E  CONTRATO DE Nº2024.03.06.1,) ',
                    'cNBS' => '123019100',
                ],
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => 1850.00,
                ],
                'trib' => [
                    'tribMun' => [
                         'tribISSQN' => 1,
                         'tpRetISSQN' => 2,
                    ],
                    'totTrib' => [
                         'indTotTrib' => 0,
                    ],
                ],
            ],
        ],
    ]);

    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    // Assertions based on the example XML structure
    expect($xml)->toContain('<DPS xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.00">')
        ->and($xml)->toContain('<infDPS Id="DPS231400310000667299238300001000000000000046">')
        ->and($xml)->toContain('<tpAmb>1</tpAmb>')
        ->and($xml)->toContain('<dhEmi>2025-12-15T11:11:09-03:00</dhEmi>')
        ->and($xml)->toContain('<verAplic>Sistema NFS-e</verAplic>')
        ->and($xml)->toContain('<serie>00001</serie>')
        ->and($xml)->toContain('<nDPS>46</nDPS>')
        ->and($xml)->toContain('<dCompet>2025-12-15</dCompet>')
        ->and($xml)->toContain('<tpEmit>1</tpEmit>')
        ->and($xml)->toContain('<cLocEmi>2314003</cLocEmi>')
        // Prestador
        ->and($xml)->toContain('<CPF>06672992383</CPF>')
        ->and($xml)->toContain('<email>naoinformado@gmail.com</email>')
        ->and($xml)->toContain('<opSimpNac>1</opSimpNac>')
        ->and($xml)->toContain('<regEspTrib>0</regEspTrib>')
        // Tomador
        ->and($xml)->toContain('<CNPJ>10237604000100</CNPJ>')
        ->and($xml)->toContain('<xNome>FUNDO MUNICIPAL DE SAUDE - VARZEA ALEGRE</xNome>')
        ->and($xml)->toContain('<cMun>2314003</cMun>')
        ->and($xml)->toContain('<CEP>63540000</CEP>')
        ->and($xml)->toContain('<xLgr>RUA DEP LUIZ OTACILIO CORREIA</xLgr>')
        ->and($xml)->toContain('<nro>-</nro>')
        ->and($xml)->toContain('<xBairro>CENTRO</xBairro>')
        // Servico
        ->and($xml)->toContain('<cLocPrestacao>2314003</cLocPrestacao>')
        ->and($xml)->toContain('<cTribNac>040601</cTribNac>')
        ->and($xml)->toContain('<cNBS>123019100</cNBS>')
        // Valores
        ->and($xml)->toContain('<vServ>1850</vServ>')
        ->and($xml)->toContain('<tribISSQN>1</tribISSQN>')
        ->and($xml)->toContain('<tpRetISSQN>2</tpRetISSQN>')
        ->and($xml)->toContain('<indTotTrib>0</indTotTrib>');
});
