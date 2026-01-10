<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\End;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\End\EndNacData;

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
