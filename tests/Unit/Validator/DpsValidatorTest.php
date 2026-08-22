<?php

use Nfse\Dto\Nfse\DpsData;
use Nfse\Validator\DpsValidator;

it('validates a valid DPS', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1, // Prestador
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});

it('fails when Prestador is missing', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => null, // Missing
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Prestador data is required.');
});

it('fails when Prestador address is missing and not emitter', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 2, // Tomador is emitter
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => null, // Missing address
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do prestador é obrigatório quando o prestador não for o emitente.');
});

it('fails when Tomador is identified but address is missing', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
            'toma' => [
                'CPF' => '12345678901', // Identified
                'xNome' => 'Tomador Teste',
                'end' => null, // Missing address
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do tomador é obrigatório quando o tomador é identificado.');
});

it('fails when Tomador has NIF but missing foreign address', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
            'toma' => [
                'NIF' => 'NIF123', // Foreign
                'xNome' => 'Tomador Estrangeiro',
                'end' => [
                    'endExt' => null, // Missing foreign address
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço no exterior do tomador é obrigatório quando identificado por NIF.');
});

it('fails when Tomador has CPF but missing national address', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
            'toma' => [
                'CPF' => '12345678901', // National
                'xNome' => 'Tomador Nacional',
                'end' => [
                    'endNac.cMun' => null, // Missing cMun
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Código do município do tomador é obrigatório para endereço nacional.');
});

// ============================================
// Testes de Validação de Valores (Rule 307, 309, 303)
// ============================================

it('fails when unconditional discount is equal to service value', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => 1000.00,
                ],
                'vDescCondIncond' => [
                    'vDescIncond' => 1000.00, // Equal to service value - invalid
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O valor do desconto incondicionado deve ser menor que o valor do serviço.');
});

it('fails when conditional discount is greater than service value', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => 1000.00,
                ],
                'vDescCondIncond' => [
                    'vDescCond' => 1500.00, // Greater than service value - invalid
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O valor do desconto condicionado deve ser menor que o valor do serviço.');
});

it('fails when service value is less than sum of deductions', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => 1000.00,
                ],
                'vDescCondIncond' => [
                    'vDescIncond' => 300.00,
                ],
                'vDedRed' => [
                    'vDR' => 500.00,
                ],
                'trib' => [
                    'tribMun' => [
                        'BM' => [
                            'vRedBCBM' => 300.00, // Total: 300 + 500 + 300 = 1100 > 1000
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O valor do serviço deve ser maior ou igual ao somatório dos valores informados para Desconto Incondicionado, Deduções/Reduções e Benefício Municipal.');
});

it('validates DPS with valid discount values', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => 1000.00,
                ],
                'vDescCondIncond' => [
                    'vDescIncond' => 100.00, // Valid
                    'vDescCond' => 50.00, // Valid
                ],
                'vDedRed' => [
                    'vDR' => 200.00,
                ],
                'trib' => [
                    'tribMun' => [
                        'BM' => [
                            'vRedBCBM' => 150.00, // Total: 100 + 200 + 150 = 450 < 1000
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});

// ============================================
// Testes de Validação de Serviço (Rule 260, 276)
// ============================================

it('fails when construction service is missing obra information', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
            'serv' => [
                'cServ' => [
                    'cTribNac' => '070201', // Construction service
                ],
                'obra' => null, // Missing obra - invalid
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O grupo de informações de obra é obrigatório para o serviço informado.');
});

it('fails when service item 12 is missing activity/event information', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
            'serv' => [
                'cServ' => [
                    'cTribNac' => '120101', // Service item 12
                ],
                'atvEvt' => null, // Missing activity/event - invalid
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O grupo de informações de Atividade/Evento é obrigatório para o serviço informado.');
});

it('validates DPS with construction service and obra information', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => 'DPS123'],
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
            'serv' => [
                'cServ' => [
                    'cTribNac' => '070501', // Construction service
                ],
                'obra' => [
                    'cObra' => '12345',
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});

it('rejects a DPS with a missing versao attribute', function () {
    $dps = new DpsData([
        'infDPS' => [
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
        ],
    ]);

    $result = (new DpsValidator)->validate($dps);

    expect($result->isValid)->toBeFalse()
        ->and($result->errors)->toContain('O atributo versao da DPS é obrigatório (1.00 ou 1.01).');
});

it('rejects a DPS with an invalid versao attribute', function () {
    $dps = new DpsData([
        '@attributes' => ['versao' => '1.0'],
        'infDPS' => [
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
            ],
        ],
    ]);

    $result = (new DpsValidator)->validate($dps);

    expect($result->isValid)->toBeFalse()
        ->and($result->errors)->toContain('A versão da DPS deve ser 1.00 ou 1.01 conforme o schema (TVerNFSe).');
});
