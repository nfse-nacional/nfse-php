<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\RegTribData;

it('can instantiate RegTribData', function () {
    $dto = new RegTribData([]);
    expect($dto)->toBeInstanceOf(RegTribData::class);
});

it('can set properties for RegTribData', function () {
    $data = [
        'opSimpNac' => 'test',
        'regApTribSN' => 'test',
        'regEspTrib' => 'test',
    ];

    $dto = map(RegTribData::class, $data);

    expect($dto->opSimpNac)->toBe('test');
    expect($dto->regApTribSN)->toBe('test');
    expect($dto->regEspTrib)->toBe('test');
});
