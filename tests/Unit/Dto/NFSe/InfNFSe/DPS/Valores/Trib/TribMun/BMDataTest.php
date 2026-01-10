<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMun;

use Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMun\BMData;

it('can instantiate BMData', function () {
    $dto = new BMData([]);
    expect($dto)->toBeInstanceOf(BMData::class);
});

it('can set properties for BMData', function () {
    $data = [
        'nBM' => 'test',
        'vRedBCBM' => 'test',
        'pRedBCBM' => 'test',
    ];

    $dto = map(BMData::class, $data);

    expect($dto->nBM)->toBe('test');
    expect($dto->vRedBCBM)->toBe('test');
    expect($dto->pRedBCBM)->toBe('test');
});
