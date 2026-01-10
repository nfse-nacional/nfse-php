<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMun;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMun\ExigSuspData;

it('can instantiate ExigSuspData via map helper', function () {
    $dto = \map(ExigSuspData::class, []);
    expect($dto)->toBeInstanceOf(ExigSuspData::class);
});

it('can map properties for ExigSuspData', function () {
    $data = [
        'tpSusp' => 'test',
        'nProcesso' => 'test',
    ];

    $dto = \map(ExigSuspData::class, $data);

    expect($dto->tpSusp)->toBe('test');
    expect($dto->nProcesso)->toBe('test');
});
