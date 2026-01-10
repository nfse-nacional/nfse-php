<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\Valores\Trib\TribMun;

use Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMun\BMData;

it('can instantiate BMData via map helper', function () {
    $dto = \map(BMData::class, []);
    expect($dto)->toBeInstanceOf(BMData::class);
});

it('can map properties for BMData', function () {
    $data = [
        'nBM' => 'test',
        'vRedBCBM' => 'test',
        'pRedBCBM' => 'test',
    ];

    $dto = \map(BMData::class, $data);

    expect($dto->nBM)->toBe('test');
    expect($dto->vRedBCBM)->toBe('test');
    expect($dto->pRedBCBM)->toBe('test');
});
