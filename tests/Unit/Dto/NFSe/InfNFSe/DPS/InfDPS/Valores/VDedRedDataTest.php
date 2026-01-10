<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRedData;

it('can instantiate VDedRedData', function () {
    $dto = new VDedRedData([]);
    expect($dto)->toBeInstanceOf(VDedRedData::class);
});

it('can set properties for VDedRedData', function () {
    $data = [
        'pDR' => 'test',
        'vDR' => 'test',
    ];

    $dto = map(VDedRedData::class, $data);

    expect($dto->pDR)->toBe('test');
    expect($dto->vDR)->toBe('test');
});
