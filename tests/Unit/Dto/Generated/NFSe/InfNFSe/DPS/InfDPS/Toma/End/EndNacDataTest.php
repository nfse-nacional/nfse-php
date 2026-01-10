<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Toma\End;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End\EndNacData;

it('can instantiate EndNacData via map helper', function () {
    $dto = \map(EndNacData::class, []);
    expect($dto)->toBeInstanceOf(EndNacData::class);
});

it('can map properties for EndNacData', function () {
    $data = [
        'cMun' => 'test',
        'CEP' => 'test',
    ];

    $dto = \map(EndNacData::class, $data);

    expect($dto->cMun)->toBe('test');
    expect($dto->CEP)->toBe('test');
});
