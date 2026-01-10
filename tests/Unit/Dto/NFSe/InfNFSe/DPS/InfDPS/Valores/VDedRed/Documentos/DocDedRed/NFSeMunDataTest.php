<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\NFSeMunData;

it('can instantiate NFSeMunData', function () {
    $dto = new NFSeMunData([]);
    expect($dto)->toBeInstanceOf(NFSeMunData::class);
});

it('can set properties for NFSeMunData', function () {
    $data = [
        'cMunNFSeMun' => 'test',
        'nNFSeMun' => 'test',
        'cVerifNFSeMun' => 'test',
    ];

    $dto = map(NFSeMunData::class, $data);

    expect($dto->cMunNFSeMun)->toBe('test');
    expect($dto->nNFSeMun)->toBe('test');
    expect($dto->cVerifNFSeMun)->toBe('test');
});
