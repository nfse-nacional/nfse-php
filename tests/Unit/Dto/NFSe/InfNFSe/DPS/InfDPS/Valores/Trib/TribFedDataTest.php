<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFedData;

it('can instantiate TribFedData', function () {
    $dto = new TribFedData([]);
    expect($dto)->toBeInstanceOf(TribFedData::class);
});

it('can set properties for TribFedData', function () {
    $data = [
        'pisconfins' => 'test',
        'vRetCP' => 'test',
        'vRetIRRF' => 'test',
        'vRetCSLL' => 'test',
    ];

    $dto = map(TribFedData::class, $data);

    expect($dto->pisconfins)->toBe('test');
    expect($dto->vRetCP)->toBe('test');
    expect($dto->vRetIRRF)->toBe('test');
    expect($dto->vRetCSLL)->toBe('test');
});
