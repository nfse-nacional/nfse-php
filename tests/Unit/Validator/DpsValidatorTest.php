<?php

use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Validator\DpsValidator;

function createValidDpsData(array $overrides = []): array {
    $base = [
        'infDPS' => [
            'id' => 'DPS123',
            'tpAmb' => '2',
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => '1',
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac' => [
                        'cMun' => '1234567',
                        'CEP' => '12345678',
                    ],
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
            'toma' => [
                 'CPF' => '12345678901',
                 'xNome' => 'Tomador Teste',
                 'end' => [
                      'endNac' => ['cMun' => '1234567', 'CEP' => '12345678'],
                  ]
            ],
            'serv' => [
                'cServ' => ['cTribNac' => '010101', 'xDescServ' => 'Teste']
            ],
            'valores' => [
                'vServPrest' => ['vServ' => '100.00']
            ]
        ],
        'versao' => '1.00' // Attribute
    ];

    return array_replace_recursive($base, $overrides);
}

it('validates a valid DPS', function () {
    $data = createValidDpsData();
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});

it('fails when Prestador is missing', function () {
    $data = createValidDpsData(['infDPS' => ['prest' => null]]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Prestador data is required.');
});

it('fails when Prestador address is missing and not emitter', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'tpEmit' => '2', // Tomador is emitter
            'prest' => ['end' => null]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do prestador é obrigatório quando o prestador não for o emitente.');
});

it('fails when Tomador is identified but address is missing', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'toma' => [
                'CPF' => '12345678901',
                'end' => null
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do tomador é obrigatório quando o tomador é identificado.');
});

it('fails when Tomador has NIF but missing foreign address', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'toma' => [
                'NIF' => 'NIF123',
                // Remove CPF/CNPJ from recursive merge if needed, but Valinor just maps what's there. 
                // But createValidDpsData has CPF. If we pass NIF, it has NIF, but still CPF if we don't unset it.
                // Assuming NIF implies identified.
                'end' => [
                    'endExt' => null,
                    'endNac' => null 
                ]
            ]
        ]
    ]);
    
    // Unset CPF manually to force Just NIF identification logic if validator distinguishes.
    // But validator checks: $isIdentified = $tomador->cpf || ...
    // If CPF is set, it checks address. Foreign address check is if NIF !== null.
    // So even if CPF is there, if NIF is there, foreign address is required.
    
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço no exterior do tomador é obrigatório quando identificado por NIF.');
});

it('fails when Tomador has CPF but missing national address', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'toma' => [
                'CPF' => '12345678901',
                'end' => [
                    'endNac' => null
                ]
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    // If endNac is null, it fails.
    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Código do município do tomador é obrigatório para endereço nacional.');
});

it('fails when unconditional discount is equal to service value', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'valores' => [
                'vServPrest' => ['vServ' => '1000.00'],
                'vDescCondIncond' => ['vDescIncond' => '1000.00']
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O valor do desconto incondicionado deve ser menor que o valor do serviço.');
});

it('fails when conditional discount is greater than service value', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'valores' => [
                'vServPrest' => ['vServ' => '1000.00'],
                'vDescCondIncond' => ['vDescCond' => '1500.00']
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O valor do desconto condicionado deve ser menor que o valor do serviço.');
});

it('fails when soervice value is less than sum of deductions', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'valores' => [
                'vServPrest' => ['vServ' => '1000.00'], // vServ
                'vDescCondIncond' => ['vDescIncond' => '300.00'], // + 300
                'vDedRed' => ['vDedRed' => '500.00'], // + 500 = 800
                'trib' => [
                    'tribMun' => [
                        'tribISSQN' => '1',
                        'BM' => [ 'vRedBCBM' => '300.00' ] // + 300 = 1100 > 1000
                    ]
                ]
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O valor do serviço deve ser maior ou igual ao somatório dos valores informados para Desconto Incondicionado, Deduções/Reduções e Benefício Municipal.');
});

it('validates DPS with valid discount values', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'valores' => [
                'vServPrest' => ['vServ' => '1000.00'],
                'vDescCondIncond' => ['vDescIncond' => '100.00', 'vDescCond' => '50.00'],
                'vDedRed' => ['vDedRed' => '200.00'],
                'trib' => [
                    'tribMun' => [
                        'BM' => [ 'vRedBCBM' => '150.00' ] // 100+200+150 = 450 < 1000
                    ]
                ]
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});

it('fails when construction service is missing obra information', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'serv' => [
                'cServ' => ['cTribNac' => '070201'],
                'obra' => null
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O grupo de informações de obra é obrigatório para o serviço informado.');
});

it('fails when service item 12 is missing activity/event information', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'serv' => [
                'cServ' => ['cTribNac' => '120101'],
                'atvEvento' => null
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('O grupo de informações de Atividade/Evento é obrigatório para o serviço informado.');
});

it('validates DPS with construction service and obra information', function () {
    $data = createValidDpsData([
        'infDPS' => [
            'serv' => [
                'cServ' => ['cTribNac' => '070501'],
                'obra' => ['cObra' => '12345']
            ]
        ]
    ]);
    $dps = \map(DPSData::class, $data);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});
