<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe;

use Nfse\Dto\NFSe\InfNFSeData;

it('can instantiate InfNFSeData via map helper', function () {
    $dto = \map(InfNFSeData::class, []);
    expect($dto)->toBeInstanceOf(InfNFSeData::class);
});

it('can map properties for InfNFSeData', function () {
    $data = [
        'id' => 'test',
        'xLocEmi' => 'test',
        'xLocPrestacao' => 'test',
        'nNFSe' => 'test',
        'cLocIncid' => 'test',
        'xLocIncid' => 'test',
        'xTribNac' => 'test',
        'xTribMun' => 'test',
        'xNBS' => 'test',
        'verAplic' => 'test',
        'ambGer' => 'test',
        'tpEmis' => 'test',
        'procEmi' => 'test',
        'cStat' => 'test',
        'dhProc' => 'test',
        'nDFSe' => 'test',
        'xOutInf' => 'test',
    ];

    $dto = \map(InfNFSeData::class, $data);

    expect($dto->id)->toBe('test');
    expect($dto->xLocEmi)->toBe('test');
    expect($dto->xLocPrestacao)->toBe('test');
    expect($dto->nNFSe)->toBe('test');
    expect($dto->cLocIncid)->toBe('test');
    expect($dto->xLocIncid)->toBe('test');
    expect($dto->xTribNac)->toBe('test');
    expect($dto->xTribMun)->toBe('test');
    expect($dto->xNBS)->toBe('test');
    expect($dto->verAplic)->toBe('test');
    expect($dto->ambGer)->toBe('test');
    expect($dto->tpEmis)->toBe('test');
    expect($dto->procEmi)->toBe('test');
    expect($dto->cStat)->toBe('test');
    expect($dto->dhProc)->toBe('test');
    expect($dto->nDFSe)->toBe('test');
    expect($dto->xOutInf)->toBe('test');
});
