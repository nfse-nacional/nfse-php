<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VServPrestData;

it('can instantiate VServPrestData via map helper', function () {
    $dto = \map(VServPrestData::class, []);
    expect($dto)->toBeInstanceOf(VServPrestData::class);
});

it('can map properties for VServPrestData', function () {
    $data = [
        'vReceb' => 'test',
        'vServ' => 'test',
    ];

    $dto = \map(VServPrestData::class, $data);

    expect($dto->vReceb)->toBe('test');
    expect($dto->vServ)->toBe('test');
});
