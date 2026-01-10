<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\LocPrestData;

it('can instantiate LocPrestData via map helper', function () {
    $dto = \map(LocPrestData::class, []);
    expect($dto)->toBeInstanceOf(LocPrestData::class);
});

it('can map properties for LocPrestData', function () {
    $data = [
        'cLocPrestacao' => 'test',
        'cPaisPrestacao' => 'test',
    ];

    $dto = \map(LocPrestData::class, $data);

    expect($dto->cLocPrestacao)->toBe('test');
    expect($dto->cPaisPrestacao)->toBe('test');
});
