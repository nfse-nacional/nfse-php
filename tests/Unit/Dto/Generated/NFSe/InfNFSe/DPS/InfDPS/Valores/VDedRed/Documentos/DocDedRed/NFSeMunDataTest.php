<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\NFSeMunData;

it('can instantiate NFSeMunData via map helper', function () {
    $dto = \map(NFSeMunData::class, []);
    expect($dto)->toBeInstanceOf(NFSeMunData::class);
});

it('can map properties for NFSeMunData', function () {
    $data = [
        'cMunNFSeMun' => 'test',
        'nNFSeMun' => 'test',
        'cVerifNFSeMun' => 'test',
    ];

    $dto = \map(NFSeMunData::class, $data);

    expect($dto->cMunNFSeMun)->toBe('test');
    expect($dto->nNFSeMun)->toBe('test');
    expect($dto->cVerifNFSeMun)->toBe('test');
});
