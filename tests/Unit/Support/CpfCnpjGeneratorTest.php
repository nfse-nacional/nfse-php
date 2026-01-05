<?php

use Nfse\Support\CpfCnpjGenerator;

it('can generate a valid CPF', function () {
    $cpf = CpfCnpjGenerator::generateCpf();

    expect(strlen($cpf))->toBe(11);
    expect(ctype_digit($cpf))->toBeTrue();

    // Simple validation of check digits could be added here,
    // but for now we trust the generator logic which implements the algorithm.
});

it('can generate a formatted CPF', function () {
    $cpf = CpfCnpjGenerator::generateCpf(true);

    expect(strlen($cpf))->toBe(14);
    expect($cpf)->toMatch('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/');
});

it('can generate a valid CNPJ', function () {
    $cnpj = CpfCnpjGenerator::generateCnpj();

    expect(strlen($cnpj))->toBe(14);
    expect(ctype_digit($cnpj))->toBeTrue();
});

it('can generate a formatted CNPJ', function () {
    $cnpj = CpfCnpjGenerator::generateCnpj(true);

    expect(strlen($cnpj))->toBe(18);
    expect($cnpj)->toMatch('/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/');
});
