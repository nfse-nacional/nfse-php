<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\SubstData;

it('can instantiate SubstData', function () {
    $dto = new SubstData([]);
    expect($dto)->toBeInstanceOf(SubstData::class);
});

it('can set properties for SubstData', function () {
    $data = [
        'chSubstda' => 'test',
        'cMotivo' => 'test',
        'xMotivo' => 'test',
    ];

    $dto = map(SubstData::class, $data);

    expect($dto->chSubstda)->toBe('test');
    expect($dto->cMotivo)->toBe('test');
    expect($dto->xMotivo)->toBe('test');
});
