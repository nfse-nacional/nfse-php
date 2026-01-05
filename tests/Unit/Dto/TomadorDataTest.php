<?php

use Nfse\Dto\Nfse\EnderecoData;
use Nfse\Dto\Nfse\EnderecoExteriorData;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Support\CpfCnpjGenerator;

it('can instantiate tomador as PF (Person)', function () {
    $cpf = CpfCnpjGenerator::generateCpf();
    $tomador = new TomadorData(
        cpf: $cpf,
        cnpj: null,
        nif: null,
        codigoNaoNif: null,
        caepf: null,
        inscricaoMunicipal: null,
        nome: 'João da Silva',
        endereco: new EnderecoData(
            codigoMunicipio: '3550308',
            cep: '01001000',
            logradouro: 'Praça da Sé',
            numero: '1',
            bairro: 'Sé',
            complemento: null,
            enderecoExterior: null
        ),
        telefone: '11999999999',
        email: 'joao@email.com'
    );

    expect($tomador)->toBeInstanceOf(TomadorData::class);
    expect($tomador->cpf)->toBe($cpf);
    expect($tomador->cnpj)->toBeNull();
});

it('can instantiate tomador as PJ (Company)', function () {
    $cnpj = CpfCnpjGenerator::generateCnpj();
    $tomador = new TomadorData(
        cpf: null,
        cnpj: $cnpj,
        nif: null,
        codigoNaoNif: null,
        caepf: null,
        inscricaoMunicipal: '123456',
        nome: 'Empresa Legal Ltda',
        endereco: new EnderecoData(
            codigoMunicipio: '3550308',
            cep: '01001000',
            logradouro: 'Av Paulista',
            numero: '1000',
            bairro: 'Bela Vista',
            complemento: 'Conj 101',
            enderecoExterior: null
        ),
        telefone: '1133334444',
        email: 'contato@empresa.com'
    );

    expect($tomador)->toBeInstanceOf(TomadorData::class);
    expect($tomador->cnpj)->toBe($cnpj);
    expect($tomador->cpf)->toBeNull();
});

it('can instantiate tomador as Foreigner (Estrangeiro)', function () {
    $tomador = new TomadorData(
        cpf: null,
        cnpj: null,
        nif: '123456789',
        codigoNaoNif: null,
        caepf: null,
        inscricaoMunicipal: null,
        nome: 'John Doe',
        endereco: new EnderecoData(
            codigoMunicipio: null,
            cep: null,
            logradouro: '5th Avenue',
            numero: '100',
            bairro: 'Manhattan',
            complemento: null,
            enderecoExterior: new EnderecoExteriorData(
                codigoPais: 'US',
                codigoEnderecamentoPostal: '10001',
                cidade: 'New York',
                estadoProvinciaRegiao: 'NY'
            )
        ),
        telefone: '15551234567',
        email: 'john.doe@email.com'
    );

    expect($tomador)->toBeInstanceOf(TomadorData::class);
    expect($tomador->nif)->toBe('123456789');
    expect($tomador->endereco->enderecoExterior)->toBeInstanceOf(EnderecoExteriorData::class);
    expect($tomador->endereco->enderecoExterior->codigoPais)->toBe('US');
});
