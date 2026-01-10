<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\Emit;

use Nfse\Dto\NFSe\InfNFSe\Emit\EnderNacData;

it('can instantiate EnderNacData', function () {
    $dto = new EnderNacData([]);
    expect($dto)->toBeInstanceOf(EnderNacData::class);
});

it('can set properties for EnderNacData', function () {
    $data = [
        'xLgr' => 'test',
        'nro' => 'test',
        'xCpl' => 'test',
        'xBairro' => 'test',
        'cMun' => 'test',
        'UF' => 'test',
        'CEP' => 'test',
    ];

    $dto = map(EnderNacData::class, $data);

    expect($dto->xLgr)->toBe('test');
    expect($dto->nro)->toBe('test');
    expect($dto->xCpl)->toBe('test');
    expect($dto->xBairro)->toBe('test');
    expect($dto->cMun)->toBe('test');
    expect($dto->uF)->toBe('test');
    expect($dto->cEP)->toBe('test');
});
