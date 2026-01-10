<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\End;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\End\EndNacData;

it('can instantiate EndNacData', function () {
    $dto = new EndNacData([]);
    expect($dto)->toBeInstanceOf(EndNacData::class);
});

it('can set properties for EndNacData', function () {
    $data = [
        'cMun' => 'test',
        'CEP' => 'test',
    ];

    $dto = map(EndNacData::class, $data);

    expect($dto->cMun)->toBe('test');
    expect($dto->cEP)->toBe('test');
});
