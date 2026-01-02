<?php

use Nfse\Support\DocumentFormatter;

test('it can format CPF', function () {
    $cpf = '12345678901';
    $formatted = DocumentFormatter::formatCpf($cpf);
    expect($formatted)->toBe('123.456.789-01');
});

test('it can format CPF with extra characters', function () {
    $cpf = '123.456.789-01';
    $formatted = DocumentFormatter::formatCpf($cpf);
    expect($formatted)->toBe('123.456.789-01');
});

test('it can format CNPJ', function () {
    $cnpj = '12345678000199';
    $formatted = DocumentFormatter::formatCnpj($cnpj);
    expect($formatted)->toBe('12.345.678/0001-99');
});

test('it can format CNPJ with extra characters', function () {
    $cnpj = '12.345.678/0001-99';
    $formatted = DocumentFormatter::formatCnpj($cnpj);
    expect($formatted)->toBe('12.345.678/0001-99');
});

test('it can unformat a value', function () {
    $value = '12.345.678/0001-99';
    $unformatted = DocumentFormatter::unformat($value);
    expect($unformatted)->toBe('12345678000199');
});

test('it can format CEP', function () {
    $cep = '12345678';
    $formatted = DocumentFormatter::formatCep($cep);
    expect($formatted)->toBe('12345-678');
});

test('it can format CEP with extra characters', function () {
    $cep = '12345-678';
    $formatted = DocumentFormatter::formatCep($cep);
    expect($formatted)->toBe('12345-678');
});
