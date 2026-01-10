<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe;

use Nfse\Dto\NFSe\InfNFSe\DPSData;

it('can instantiate DPSData via map helper', function () {
    $dto = \map(DPSData::class, []);
    expect($dto)->toBeInstanceOf(DPSData::class);
});

it('can map properties for DPSData', function () {
    $data = [
        'versao' => 'test',
        'Signature' => 'test',
    ];

    $dto = \map(DPSData::class, $data);

    expect($dto->versao)->toBe('test');
    expect($dto->Signature)->toBe('test');
});
