<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Serv\Obra;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\Obra\EndData;

it('can instantiate EndData via map helper', function () {
    $dto = \map(EndData::class, []);
    expect($dto)->toBeInstanceOf(EndData::class);
});

it('can map properties for EndData', function () {
    $data = [
        'CEP' => 'test',
        'xLgr' => 'test',
        'nro' => 'test',
        'xCpl' => 'test',
        'xBairro' => 'test',
    ];

    $dto = \map(EndData::class, $data);

    expect($dto->CEP)->toBe('test');
    expect($dto->xLgr)->toBe('test');
    expect($dto->nro)->toBe('test');
    expect($dto->xCpl)->toBe('test');
    expect($dto->xBairro)->toBe('test');
});
