<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ServData;

it('can instantiate ServData via map helper', function () {
    $dto = \map(ServData::class, []);
    expect($dto)->toBeInstanceOf(ServData::class);
});

it('can map properties for ServData', function () {
    $data = [
        'infoComplem' => 'test',
        'idDocTec' => 'test',
        'docRef' => 'test',
        'xInfComp' => 'test',
    ];

    $dto = \map(ServData::class, $data);

    expect($dto->infoComplem)->toBe('test');
    expect($dto->idDocTec)->toBe('test');
    expect($dto->docRef)->toBe('test');
    expect($dto->xInfComp)->toBe('test');
});
