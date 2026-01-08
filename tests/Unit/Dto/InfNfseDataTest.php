<?php

use Nfse\Dto\Nfse\InfNfseData;
use Nfse\Enums\CodigoStatus;

it('casts cStat to CodigoStatus enum', function () {
    $data = new InfNfseData([
        'cStat' => 100,
    ]);

    expect($data->codigoStatus)->toBeInstanceOf(CodigoStatus::class);
    expect($data->codigoStatus)->toBe(CodigoStatus::NfseGerada);
});

it('casts cStat to CodigoStatus enum when value is string', function () {
    $data = new InfNfseData([
        'cStat' => '100',
    ]);

    expect($data->codigoStatus)->toBeInstanceOf(CodigoStatus::class);
    expect($data->codigoStatus)->toBe(CodigoStatus::NfseGerada);
});
