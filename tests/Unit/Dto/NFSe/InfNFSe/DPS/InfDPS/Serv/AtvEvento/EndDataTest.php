<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEvento;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEvento\EndData;

it('can instantiate EndData', function () {
    $dto = new EndData([]);
    expect($dto)->toBeInstanceOf(EndData::class);
});

it('can set properties for EndData', function () {
    $data = [
        'CEP' => 'test',
        'xLgr' => 'test',
        'nro' => 'test',
        'xCpl' => 'test',
        'xBairro' => 'test',
    ];

    $dto = map(EndData::class, $data);

    expect($dto->cEP)->toBe('test');
    expect($dto->xLgr)->toBe('test');
    expect($dto->nro)->toBe('test');
    expect($dto->xCpl)->toBe('test');
    expect($dto->xBairro)->toBe('test');
});
