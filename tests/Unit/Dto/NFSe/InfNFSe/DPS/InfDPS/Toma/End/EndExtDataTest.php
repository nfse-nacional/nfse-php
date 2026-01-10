<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End\EndExtData;

it('can instantiate EndExtData', function () {
    $dto = new EndExtData([]);
    expect($dto)->toBeInstanceOf(EndExtData::class);
});

it('can set properties for EndExtData', function () {
    $data = [
        'cPais' => 'test',
        'cEndPost' => 'test',
        'xCidade' => 'test',
        'xEstProvReg' => 'test',
    ];

    $dto = map(EndExtData::class, $data);

    expect($dto->cPais)->toBe('test');
    expect($dto->cEndPost)->toBe('test');
    expect($dto->xCidade)->toBe('test');
    expect($dto->xEstProvReg)->toBe('test');
});
