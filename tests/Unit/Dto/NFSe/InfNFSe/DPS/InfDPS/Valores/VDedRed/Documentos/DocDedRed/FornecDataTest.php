<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\FornecData;

it('can instantiate FornecData', function () {
    $dto = new FornecData([]);
    expect($dto)->toBeInstanceOf(FornecData::class);
});

it('can set properties for FornecData', function () {
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

    $dto = map(FornecData::class, $data);

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
