<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe;

use Nfse\Dto\NFSe\InfNFSe\ValoresData;

it('can instantiate ValoresData via map helper', function () {
    $dto = \map(ValoresData::class, []);
    expect($dto)->toBeInstanceOf(ValoresData::class);
});

it('can map properties for ValoresData', function () {
    $data = [
        'vCalcDR' => 'test',
        'tpBM' => 'test',
        'vCalcBM' => 'test',
        'vBC' => 'test',
        'pAliqAplic' => 'test',
        'vISSQN' => 'test',
        'vTotalRet' => 'test',
        'vLiq' => 'test',
    ];

    $dto = \map(ValoresData::class, $data);

    expect($dto->vCalcDR)->toBe('test');
    expect($dto->tpBM)->toBe('test');
    expect($dto->vCalcBM)->toBe('test');
    expect($dto->vBC)->toBe('test');
    expect($dto->pAliqAplic)->toBe('test');
    expect($dto->vISSQN)->toBe('test');
    expect($dto->vTotalRet)->toBe('test');
    expect($dto->vLiq)->toBe('test');
});
