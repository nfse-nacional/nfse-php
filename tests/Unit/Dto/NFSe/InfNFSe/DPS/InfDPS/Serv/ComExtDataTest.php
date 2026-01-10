<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\ComExtData;

it('can instantiate ComExtData', function () {
    $dto = new ComExtData([]);
    expect($dto)->toBeInstanceOf(ComExtData::class);
});

it('can set properties for ComExtData', function () {
    $data = [
        'mdPrestacao' => 'test',
        'vincPrest' => 'test',
        'tpMoeda' => 'test',
        'vServMoeda' => 'test',
        'mecAFComexP' => 'test',
        'mecAFComexT' => 'test',
        'movTempBens' => 'test',
        'nDI' => 'test',
        'nRE' => 'test',
        'mdic' => 'test',
    ];

    $dto = map(ComExtData::class, $data);

    expect($dto->mdPrestacao)->toBe('test');
    expect($dto->vincPrest)->toBe('test');
    expect($dto->tpMoeda)->toBe('test');
    expect($dto->vServMoeda)->toBe('test');
    expect($dto->mecAFComexP)->toBe('test');
    expect($dto->mecAFComexT)->toBe('test');
    expect($dto->movTempBens)->toBe('test');
    expect($dto->nDI)->toBe('test');
    expect($dto->nRE)->toBe('test');
    expect($dto->mdic)->toBe('test');
});
