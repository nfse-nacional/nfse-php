<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\EndData;

it('can instantiate EndData', function () {
    $dto = new EndData([]);
    expect($dto)->toBeInstanceOf(EndData::class);
});

it('can set properties for EndData', function () {
    $data = [
        'xLgr' => 'test',
        'nro' => 'test',
        'xCpl' => 'test',
        'xBairro' => 'test',
    ];

    $dto = map(EndData::class, $data);

    expect($dto->xLgr)->toBe('test');
    expect($dto->nro)->toBe('test');
    expect($dto->xCpl)->toBe('test');
    expect($dto->xBairro)->toBe('test');
});
