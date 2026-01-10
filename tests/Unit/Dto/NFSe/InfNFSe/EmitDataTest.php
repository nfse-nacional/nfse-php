<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe;

use Nfse\Dto\NFSe\InfNFSe\EmitData;

it('can instantiate EmitData', function () {
    $dto = new EmitData([]);
    expect($dto)->toBeInstanceOf(EmitData::class);
});

it('can set properties for EmitData', function () {
    $data = [
        'CNPJ' => 'test',
        'CPF' => 'test',
        'IM' => 'test',
        'xNome' => 'test',
        'xFant' => 'test',
        'fone' => 'test',
        'email' => 'test',
    ];

    $dto = map(EmitData::class, $data);

    expect($dto->cNPJ)->toBe('test');
    expect($dto->cPF)->toBe('test');
    expect($dto->iM)->toBe('test');
    expect($dto->xNome)->toBe('test');
    expect($dto->xFant)->toBe('test');
    expect($dto->fone)->toBe('test');
    expect($dto->email)->toBe('test');
});
