<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\ObraData;

it('can instantiate ObraData via map helper', function () {
    $dto = \map(ObraData::class, []);
    expect($dto)->toBeInstanceOf(ObraData::class);
});

it('can map properties for ObraData', function () {
    $data = [
        'inscImobFisc' => 'test',
        'cObra' => 'test',
    ];

    $dto = \map(ObraData::class, $data);

    expect($dto->inscImobFisc)->toBe('test');
    expect($dto->cObra)->toBe('test');
});
