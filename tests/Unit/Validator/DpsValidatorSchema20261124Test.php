<?php

namespace Nfse\Tests\Unit\Validator;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Validator\DpsValidator;

function dpsParaValidarSchema(array $infDps = []): DpsData
{
    return new DpsData([
        '@attributes' => ['versao' => '1.01'],
        'infDPS' => array_replace([
            'tpAmb' => 2,
            'dhEmi' => '2026-11-26T10:00:00-03:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2026-11-26',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
            'prest' => [
                'CNPJ' => '12345678000199',
                'xNome' => 'Prestador Exemplo Ltda',
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
                'trib' => ['tribMun.tribISSQN' => 1],
            ],
        ], $infDps),
    ]);
}

it('exige indDest no schema 20261124 e nao exige no schema atual', function () {
    $dps = dpsParaValidarSchema();

    expect((new DpsValidator)->validate($dps)->errors)->toBeEmpty()
        ->and((new DpsValidator)->validate($dps, '20261124')->errors)
        ->toContain('O indicador de destinatário é obrigatório no schema 20261124.');
});

it('recusa destinatario quando o indicador nao e 1 no schema 20261124', function () {
    $dps = dpsParaValidarSchema([
        'indDest' => 0,
        'dest' => [
            'CNPJ' => '98765432000188',
            'xNome' => 'Destinatario Exemplo Ltda',
        ],
    ]);

    expect((new DpsValidator)->validate($dps, '20261124')->errors)
        ->toContain('O destinatário do serviço só deve ser identificado quando o indicador de destinatário for 1.');
});

it('recusa campo antigo de comercio exterior no schema 20261124', function () {
    $dps = dpsParaValidarSchema([
        'indDest' => 0,
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
                'vServMoeda' => 10.5,
                'mecAFComexP' => '01',
                'mecAFComexT' => '01',
                'movTempBens' => '1',
                'mdic' => '0',
            ],
        ],
    ]);

    expect((new DpsValidator)->validate($dps, '20261124')->errors)
        ->toContain('Os campos vServMoeda, nDI e nRE não existem no schema 20261124.')
        ->and((new DpsValidator)->validate($dps)->errors)
        ->not->toContain('Os campos vServMoeda, nDI e nRE não existem no schema 20261124.');
});

it('recusa condominios fora do subitem 99.05 no schema 20261124', function () {
    $dps = dpsParaValidarSchema([
        'indDest' => 0,
        'IBSCBS' => [
            'condominios' => [
                'dVencOrig' => '2026-11-26',
                'gCobranca' => [
                    [
                        'tpCobranca' => '01',
                        'vCobranca' => 100,
                    ],
                ],
            ],
        ],
    ]);

    expect((new DpsValidator)->validate($dps, '20261124')->errors)
        ->toContain('O grupo de condomínios só é admitido para o subitem 99.05 do código de tributação nacional.')
        ->and((new DpsValidator)->validate($dps)->errors)
        ->not->toContain('O grupo de condomínios só é admitido para o subitem 99.05 do código de tributação nacional.');
});

it('recusa descricao do tipo de cobranca quando o tipo nao e 99 no schema 20261124', function () {
    $dps = dpsParaValidarSchema([
        'indDest' => 0,
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '99.05.01',
                'xDescServ' => 'Administracao de condominio',
                'cNBS' => '112011000',
            ],
        ],
        'IBSCBS' => [
            'cIndOp' => '010101',
            'condominios' => [
                'dVencOrig' => '2026-11-26',
                'gCobranca' => [
                    [
                        'tpCobranca' => '01',
                        'xTpCobranca' => 'Taxa extra',
                        'vCobranca' => 100,
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

    expect((new DpsValidator)->validate($dps, '20261124')->errors)
        ->toContain('A descrição do tipo de cobrança só deve ser informada quando o tipo for 99.');
});
