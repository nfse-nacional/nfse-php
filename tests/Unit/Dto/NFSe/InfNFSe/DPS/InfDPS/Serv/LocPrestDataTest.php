<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\LocPrestData;

it('can instantiate LocPrestData', function () {
    $dto = new LocPrestData([]);
    expect($dto)->toBeInstanceOf(LocPrestData::class);
});

it('can set properties for LocPrestData', function () {
    $data = [
        'cLocPrestacao' => 'test',
        'cPaisPrestacao' => 'test',
    ];

    $dto = map(LocPrestData::class, $data);

    expect($dto->cLocPrestacao)->toBe('test');
    expect($dto->cPaisPrestacao)->toBe('test');
});
