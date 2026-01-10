<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe;

use Nfse\Dto\NFSe\InfNFSe\DPSData;

it('can instantiate DPSData', function () {
    $dto = new DPSData([]);
    expect($dto)->toBeInstanceOf(DPSData::class);
});

it('can set properties for DPSData', function () {
    $data = [
        'versao' => 'test',
        'Signature' => 'test',
    ];

    $dto = map(DPSData::class, $data);

    expect($dto->versao)->toBe('test');
    expect($dto->signature)->toBe('test');
});
