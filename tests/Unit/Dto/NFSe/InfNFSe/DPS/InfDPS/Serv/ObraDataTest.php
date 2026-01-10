<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\ObraData;

it('can instantiate ObraData', function () {
    $dto = new ObraData([]);
    expect($dto)->toBeInstanceOf(ObraData::class);
});

it('can set properties for ObraData', function () {
    $data = [
        'inscImobFisc' => 'test',
        'cObra' => 'test',
    ];

    $dto = map(ObraData::class, $data);

    expect($dto->inscImobFisc)->toBe('test');
    expect($dto->cObra)->toBe('test');
});
