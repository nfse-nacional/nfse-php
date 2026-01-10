<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Serv;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEventoData;

it('can instantiate AtvEventoData via map helper', function () {
    $dto = \map(AtvEventoData::class, []);
    expect($dto)->toBeInstanceOf(AtvEventoData::class);
});

it('can map properties for AtvEventoData', function () {
    $data = [
        'xNome' => 'test',
        'dtIni' => 'test',
        'dtFim' => 'test',
        'idAtvEvt' => 'test',
    ];

    $dto = \map(AtvEventoData::class, $data);

    expect($dto->xNome)->toBe('test');
    expect($dto->dtIni)->toBe('test');
    expect($dto->dtFim)->toBe('test');
    expect($dto->idAtvEvt)->toBe('test');
});
