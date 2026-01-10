<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMun;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMun\ExigSuspData;

it('can instantiate ExigSuspData', function () {
    $dto = new ExigSuspData([]);
    expect($dto)->toBeInstanceOf(ExigSuspData::class);
});

it('can set properties for ExigSuspData', function () {
    $data = [
        'tpSusp' => 'test',
        'nProcesso' => 'test',
    ];

    $dto = map(ExigSuspData::class, $data);

    expect($dto->tpSusp)->toBe('test');
    expect($dto->nProcesso)->toBe('test');
});
