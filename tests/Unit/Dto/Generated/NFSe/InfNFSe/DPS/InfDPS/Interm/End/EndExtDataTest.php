<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Interm\End;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\End\EndExtData;

it('can instantiate EndExtData via map helper', function () {
    $dto = \map(EndExtData::class, []);
    expect($dto)->toBeInstanceOf(EndExtData::class);
});

it('can map properties for EndExtData', function () {
    $data = [
        'cPais' => 'test',
        'cEndPost' => 'test',
        'xCidade' => 'test',
        'xEstProvReg' => 'test',
    ];

    $dto = \map(EndExtData::class, $data);

    expect($dto->cPais)->toBe('test');
    expect($dto->cEndPost)->toBe('test');
    expect($dto->xCidade)->toBe('test');
    expect($dto->xEstProvReg)->toBe('test');
});
