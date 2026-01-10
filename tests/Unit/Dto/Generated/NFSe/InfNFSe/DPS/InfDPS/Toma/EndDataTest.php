<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Toma;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\EndData;

it('can instantiate EndData via map helper', function () {
    $dto = \map(EndData::class, []);
    expect($dto)->toBeInstanceOf(EndData::class);
});

it('can map properties for EndData', function () {
    $data = [
        'xLgr' => 'test',
        'nro' => 'test',
        'xCpl' => 'test',
        'xBairro' => 'test',
    ];

    $dto = \map(EndData::class, $data);

    expect($dto->xLgr)->toBe('test');
    expect($dto->nro)->toBe('test');
    expect($dto->xCpl)->toBe('test');
    expect($dto->xBairro)->toBe('test');
});
