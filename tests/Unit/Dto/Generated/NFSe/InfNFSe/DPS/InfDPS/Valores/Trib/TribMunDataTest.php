<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMunData;

it('can instantiate TribMunData via map helper', function () {
    $dto = \map(TribMunData::class, []);
    expect($dto)->toBeInstanceOf(TribMunData::class);
});

it('can map properties for TribMunData', function () {
    $data = [
        'tribISSQN' => 'test',
        'cPaisResult' => 'test',
        'tpImunidade' => 'test',
        'tpRetISSQN' => 'test',
        'pAliq' => 'test',
    ];

    $dto = \map(TribMunData::class, $data);

    expect($dto->tribISSQN)->toBe('test');
    expect($dto->cPaisResult)->toBe('test');
    expect($dto->tpImunidade)->toBe('test');
    expect($dto->tpRetISSQN)->toBe('test');
    expect($dto->pAliq)->toBe('test');
});
