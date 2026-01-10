<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\EndFornecData;

it('can instantiate EndFornecData via map helper', function () {
    $dto = \map(EndFornecData::class, []);
    expect($dto)->toBeInstanceOf(EndFornecData::class);
});

it('can map properties for EndFornecData', function () {
    $data = [
        'xLgr' => 'test',
        'nro' => 'test',
        'xCpl' => 'test',
        'xBairro' => 'test',
    ];

    $dto = \map(EndFornecData::class, $data);

    expect($dto->xLgr)->toBe('test');
    expect($dto->nro)->toBe('test');
    expect($dto->xCpl)->toBe('test');
    expect($dto->xBairro)->toBe('test');
});
