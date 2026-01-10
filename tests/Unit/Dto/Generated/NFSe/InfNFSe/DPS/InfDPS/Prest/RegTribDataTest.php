<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Prest;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\RegTribData;

it('can instantiate RegTribData via map helper', function () {
    $dto = \map(RegTribData::class, []);
    expect($dto)->toBeInstanceOf(RegTribData::class);
});

it('can map properties for RegTribData', function () {
    $data = [
        'opSimpNac' => 'test',
        'regApTribSN' => 'test',
        'regEspTrib' => 'test',
    ];

    $dto = \map(RegTribData::class, $data);

    expect($dto->opSimpNac)->toBe('test');
    expect($dto->regApTribSN)->toBe('test');
    expect($dto->regEspTrib)->toBe('test');
});
