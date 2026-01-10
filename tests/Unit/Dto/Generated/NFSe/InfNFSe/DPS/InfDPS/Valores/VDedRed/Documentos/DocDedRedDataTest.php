<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRedData;

it('can instantiate DocDedRedData via map helper', function () {
    $dto = \map(DocDedRedData::class, []);
    expect($dto)->toBeInstanceOf(DocDedRedData::class);
});

it('can map properties for DocDedRedData', function () {
    $data = [
        'chNFSe' => 'test',
        'chNFe' => 'test',
        'nDocFisc' => 'test',
        'nDoc' => 'test',
        'tpDedRed' => 'test',
        'xDescOutDed' => 'test',
        'dEmiDoc' => 'test',
        'vDedutivelRedutivel' => 'test',
        'vDeducaoReducao' => 'test',
    ];

    $dto = \map(DocDedRedData::class, $data);

    expect($dto->chNFSe)->toBe('test');
    expect($dto->chNFe)->toBe('test');
    expect($dto->nDocFisc)->toBe('test');
    expect($dto->nDoc)->toBe('test');
    expect($dto->tpDedRed)->toBe('test');
    expect($dto->xDescOutDed)->toBe('test');
    expect($dto->dEmiDoc)->toBe('test');
    expect($dto->vDedutivelRedutivel)->toBe('test');
    expect($dto->vDeducaoReducao)->toBe('test');
});
