<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ServData;

it('can instantiate ServData', function () {
    $dto = new ServData([]);
    expect($dto)->toBeInstanceOf(ServData::class);
});

it('can set properties for ServData', function () {
    $data = [
        'infoComplem' => 'test',
        'idDocTec' => 'test',
        'docRef' => 'test',
        'xInfComp' => 'test',
    ];

    $dto = map(ServData::class, $data);

    expect($dto->infoComplem)->toBe('test');
    expect($dto->idDocTec)->toBe('test');
    expect($dto->docRef)->toBe('test');
    expect($dto->xInfComp)->toBe('test');
});
