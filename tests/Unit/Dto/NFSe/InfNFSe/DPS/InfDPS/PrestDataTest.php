<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\PrestData;

it('can instantiate PrestData', function () {
    $dto = new PrestData([]);
    expect($dto)->toBeInstanceOf(PrestData::class);
});

it('can set properties for PrestData', function () {
    $data = [
        'CNPJ' => 'test',
        'CPF' => 'test',
        'NIF' => 'test',
        'cNaoNIF' => 'test',
        'CAEPF' => 'test',
        'IM' => 'test',
        'xNome' => 'test',
        'endNac' => 'test',
        'fone' => 'test',
        'email' => 'test',
    ];

    $dto = map(PrestData::class, $data);

    expect($dto->cNPJ)->toBe('test');
    expect($dto->cPF)->toBe('test');
    expect($dto->nIF)->toBe('test');
    expect($dto->cNaoNIF)->toBe('test');
    expect($dto->cAEPF)->toBe('test');
    expect($dto->iM)->toBe('test');
    expect($dto->xNome)->toBe('test');
    expect($dto->endNac)->toBe('test');
    expect($dto->fone)->toBe('test');
    expect($dto->email)->toBe('test');
});
