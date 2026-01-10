<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\CServData;

it('can instantiate CServData via map helper', function () {
    $dto = \map(CServData::class, []);
    expect($dto)->toBeInstanceOf(CServData::class);
});

it('can map properties for CServData', function () {
    $data = [
        'cTribNac' => 'test',
        'cTribMun' => 'test',
        'xDescServ' => 'test',
        'cNBS' => 'test',
        'cIntContrib' => 'test',
    ];

    $dto = \map(CServData::class, $data);

    expect($dto->cTribNac)->toBe('test');
    expect($dto->cTribMun)->toBe('test');
    expect($dto->xDescServ)->toBe('test');
    expect($dto->cNBS)->toBe('test');
    expect($dto->cIntContrib)->toBe('test');
});
