<?php

namespace Nfse\Tests\Unit\Dto\Generated;

use Nfse\Dto\NFSeData;

it('can instantiate NFSeData via map helper', function () {
    $dto = \map(NFSeData::class, []);
    expect($dto)->toBeInstanceOf(NFSeData::class);
});

it('can map properties for NFSeData', function () {
    $data = [
        'versao' => 'test',
        'Signature' => 'test',
    ];

    $dto = \map(NFSeData::class, $data);

    expect($dto->versao)->toBe('test');
    expect($dto->Signature)->toBe('test');
});
