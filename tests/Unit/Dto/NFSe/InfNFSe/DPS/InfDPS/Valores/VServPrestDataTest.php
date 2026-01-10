<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VServPrestData;

it('can instantiate VServPrestData', function () {
    $dto = new VServPrestData([]);
    expect($dto)->toBeInstanceOf(VServPrestData::class);
});

it('can set properties for VServPrestData', function () {
    $data = [
        'vReceb' => 'test',
        'vServ' => 'test',
    ];

    $dto = map(VServPrestData::class, $data);

    expect($dto->vReceb)->toBe('test');
    expect($dto->vServ)->toBe('test');
});
