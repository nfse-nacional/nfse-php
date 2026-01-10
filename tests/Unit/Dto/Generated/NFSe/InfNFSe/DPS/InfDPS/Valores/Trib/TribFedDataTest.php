<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFedData;

it('can instantiate TribFedData via map helper', function () {
    $dto = \map(TribFedData::class, []);
    expect($dto)->toBeInstanceOf(TribFedData::class);
});

it('can map properties for TribFedData', function () {
    $data = [
        'pisconfins' => 'test',
        'vRetCP' => 'test',
        'vRetIRRF' => 'test',
        'vRetCSLL' => 'test',
    ];

    $dto = \map(TribFedData::class, $data);

    expect($dto->pisconfins)->toBe('test');
    expect($dto->vRetCP)->toBe('test');
    expect($dto->vRetIRRF)->toBe('test');
    expect($dto->vRetCSLL)->toBe('test');
});
