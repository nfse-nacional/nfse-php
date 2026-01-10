<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPSData;

it('can instantiate InfDPSData', function () {
    $dto = new InfDPSData([]);
    expect($dto)->toBeInstanceOf(InfDPSData::class);
});

it('can set properties for InfDPSData', function () {
    $data = [
        'id' => 'test',
        'tpAmb' => 'test',
        'dhEmi' => 'test',
        'verAplic' => 'test',
        'serie' => 'test',
        'nDPS' => 'test',
        'dCompet' => 'test',
        'tpEmit' => 'test',
        'cMotivoEmisTI' => 'test',
        'chNFSeRej' => 'test',
        'cLocEmi' => 'test',
    ];

    $dto = map(InfDPSData::class, $data);

    expect($dto->id)->toBe('test');
    expect($dto->tpAmb)->toBe('test');
    expect($dto->dhEmi)->toBe('test');
    expect($dto->verAplic)->toBe('test');
    expect($dto->serie)->toBe('test');
    expect($dto->nDPS)->toBe('test');
    expect($dto->dCompet)->toBe('test');
    expect($dto->tpEmit)->toBe('test');
    expect($dto->cMotivoEmisTI)->toBe('test');
    expect($dto->chNFSeRej)->toBe('test');
    expect($dto->cLocEmi)->toBe('test');
});
