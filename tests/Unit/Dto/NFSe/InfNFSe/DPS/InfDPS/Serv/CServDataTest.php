<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\CServData;

it('can instantiate CServData', function () {
    $dto = new CServData([]);
    expect($dto)->toBeInstanceOf(CServData::class);
});

it('can set properties for CServData', function () {
    $data = [
        'cTribNac' => 'test',
        'cTribMun' => 'test',
        'xDescServ' => 'test',
        'cNBS' => 'test',
        'cIntContrib' => 'test',
    ];

    $dto = map(CServData::class, $data);

    expect($dto->cTribNac)->toBe('test');
    expect($dto->cTribMun)->toBe('test');
    expect($dto->xDescServ)->toBe('test');
    expect($dto->cNBS)->toBe('test');
    expect($dto->cIntContrib)->toBe('test');
});
