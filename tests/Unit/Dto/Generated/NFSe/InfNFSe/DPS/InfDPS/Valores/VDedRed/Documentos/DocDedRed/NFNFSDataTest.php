<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\NFNFSData;

it('can instantiate NFNFSData via map helper', function () {
    $dto = \map(NFNFSData::class, []);
    expect($dto)->toBeInstanceOf(NFNFSData::class);
});

it('can map properties for NFNFSData', function () {
    $data = [
        'nNFS' => 'test',
        'modNFS' => 'test',
        'serieNFS' => 'test',
    ];

    $dto = \map(NFNFSData::class, $data);

    expect($dto->nNFS)->toBe('test');
    expect($dto->modNFS)->toBe('test');
    expect($dto->serieNFS)->toBe('test');
});
