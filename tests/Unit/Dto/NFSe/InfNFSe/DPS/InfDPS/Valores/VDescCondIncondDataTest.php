<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDescCondIncondData;

it('can instantiate VDescCondIncondData', function () {
    $dto = new VDescCondIncondData([]);
    expect($dto)->toBeInstanceOf(VDescCondIncondData::class);
});

it('can set properties for VDescCondIncondData', function () {
    $data = [
        'vDescIncond' => 'test',
        'vDescCond' => 'test',
    ];

    $dto = map(VDescCondIncondData::class, $data);

    expect($dto->vDescIncond)->toBe('test');
    expect($dto->vDescCond)->toBe('test');
});
