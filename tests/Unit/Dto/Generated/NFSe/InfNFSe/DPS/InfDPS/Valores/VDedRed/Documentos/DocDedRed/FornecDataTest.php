<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\FornecData;

it('can instantiate FornecData via map helper', function () {
    $dto = \map(FornecData::class, []);
    expect($dto)->toBeInstanceOf(FornecData::class);
});

it('can map properties for FornecData', function () {
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

    $dto = \map(FornecData::class, $data);

    expect($dto->CNPJ)->toBe('test');
    expect($dto->CPF)->toBe('test');
    expect($dto->NIF)->toBe('test');
    expect($dto->cNaoNIF)->toBe('test');
    expect($dto->CAEPF)->toBe('test');
    expect($dto->IM)->toBe('test');
    expect($dto->xNome)->toBe('test');
    expect($dto->fone)->toBe('test');
    expect($dto->email)->toBe('test');
});
