<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\TomaData;

it('can instantiate TomaData', function () {
    $dto = new TomaData([]);
    expect($dto)->toBeInstanceOf(TomaData::class);
});

it('can set properties for TomaData', function () {
    $data = [
        'CNPJ' => 'test',
        'CPF' => 'test',
        'NIF' => 'test',
        'cNaoNIF' => 'test',
        'CAEPF' => 'test',
        'IM' => 'test',
        'xNome' => 'test',
        'fone' => 'test',
        'email' => 'test',
    ];

    $dto = map(TomaData::class, $data);

    expect($dto->cNPJ)->toBe('test');
    expect($dto->cPF)->toBe('test');
    expect($dto->nIF)->toBe('test');
    expect($dto->cNaoNIF)->toBe('test');
    expect($dto->cAEPF)->toBe('test');
    expect($dto->iM)->toBe('test');
    expect($dto->xNome)->toBe('test');
    expect($dto->fone)->toBe('test');
    expect($dto->email)->toBe('test');
});
