<?php

use Nfse\Nfse\Dto\DpsData;
use Nfse\Nfse\Dto\EnderecoData;
use Nfse\Nfse\Dto\EnderecoExteriorData;
use Nfse\Nfse\Dto\InfDpsData;
use Nfse\Nfse\Dto\PrestadorData;
use Nfse\Nfse\Dto\TomadorData;
use Nfse\Nfse\Validator\DpsValidator;

it('validates a valid DPS', function () {
    $dps = new DpsData(
        versao: '1.00',
        infDps: new InfDpsData(
            id: 'DPS123',
            tipoAmbiente: 2,
            dataEmissao: '2023-01-01',
            versaoAplicativo: '1.0',
            serie: '1',
            numeroDps: '100',
            dataCompetencia: '2023-01-01',
            tipoEmitente: 1, // Prestador
            codigoLocalEmissao: '1234567',
            motivoEmissaoTomadorIntermediario: null,
            chaveNfseRejeitada: null,
            substituicao: null,
            prestador: new PrestadorData(
                cnpj: '12345678000199',
                cpf: null,
                nif: null,
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: '12345',
                nome: 'Prestador Teste',
                endereco: new EnderecoData(
                    codigoMunicipio: '1234567',
                    cep: '12345678',
                    logradouro: 'Rua Teste',
                    numero: '100',
                    bairro: 'Centro',
                    complemento: null,
                    enderecoExterior: null
                ),
                telefone: null,
                email: null,
                regimeTributario: null
            ),
            tomador: null,
            intermediario: null,
            servico: null,
            valores: null
        )
    );

    $validator = new DpsValidator();
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});

it('fails when Prestador is missing', function () {
    $dps = new DpsData(
        versao: '1.00',
        infDps: new InfDpsData(
            id: 'DPS123',
            tipoAmbiente: 2,
            dataEmissao: '2023-01-01',
            versaoAplicativo: '1.0',
            serie: '1',
            numeroDps: '100',
            dataCompetencia: '2023-01-01',
            tipoEmitente: 1,
            codigoLocalEmissao: '1234567',
            motivoEmissaoTomadorIntermediario: null,
            chaveNfseRejeitada: null,
            substituicao: null,
            prestador: null, // Missing
            tomador: null,
            intermediario: null,
            servico: null,
            valores: null
        )
    );

    $validator = new DpsValidator();
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Prestador data is required.');
});

it('fails when Prestador address is missing and not emitter', function () {
    $dps = new DpsData(
        versao: '1.00',
        infDps: new InfDpsData(
            id: 'DPS123',
            tipoAmbiente: 2,
            dataEmissao: '2023-01-01',
            versaoAplicativo: '1.0',
            serie: '1',
            numeroDps: '100',
            dataCompetencia: '2023-01-01',
            tipoEmitente: 2, // Tomador is emitter
            codigoLocalEmissao: '1234567',
            motivoEmissaoTomadorIntermediario: null,
            chaveNfseRejeitada: null,
            substituicao: null,
            prestador: new PrestadorData(
                cnpj: '12345678000199',
                cpf: null,
                nif: null,
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: '12345',
                nome: 'Prestador Teste',
                endereco: null, // Missing address
                telefone: null,
                email: null,
                regimeTributario: null
            ),
            tomador: null,
            intermediario: null,
            servico: null,
            valores: null
        )
    );

    $validator = new DpsValidator();
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do prestador é obrigatório quando o prestador não for o emitente.');
});

it('fails when Tomador is identified but address is missing', function () {
    $dps = new DpsData(
        versao: '1.00',
        infDps: new InfDpsData(
            id: 'DPS123',
            tipoAmbiente: 2,
            dataEmissao: '2023-01-01',
            versaoAplicativo: '1.0',
            serie: '1',
            numeroDps: '100',
            dataCompetencia: '2023-01-01',
            tipoEmitente: 1,
            codigoLocalEmissao: '1234567',
            motivoEmissaoTomadorIntermediario: null,
            chaveNfseRejeitada: null,
            substituicao: null,
            prestador: new PrestadorData(
                cnpj: '12345678000199',
                cpf: null,
                nif: null,
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: '12345',
                nome: 'Prestador Teste',
                endereco: new EnderecoData(
                    codigoMunicipio: '1234567',
                    cep: '12345678',
                    logradouro: 'Rua Teste',
                    numero: '100',
                    bairro: 'Centro',
                    complemento: null,
                    enderecoExterior: null
                ),
                telefone: null,
                email: null,
                regimeTributario: null
            ),
            tomador: new TomadorData(
                cpf: '12345678901', // Identified
                cnpj: null,
                nif: null,
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: null,
                nome: 'Tomador Teste',
                endereco: null, // Missing address
                telefone: null,
                email: null
            ),
            intermediario: null,
            servico: null,
            valores: null
        )
    );

    $validator = new DpsValidator();
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do tomador é obrigatório quando o tomador é identificado.');
});

it('fails when Tomador has NIF but missing foreign address', function () {
    $dps = new DpsData(
        versao: '1.00',
        infDps: new InfDpsData(
            id: 'DPS123',
            tipoAmbiente: 2,
            dataEmissao: '2023-01-01',
            versaoAplicativo: '1.0',
            serie: '1',
            numeroDps: '100',
            dataCompetencia: '2023-01-01',
            tipoEmitente: 1,
            codigoLocalEmissao: '1234567',
            motivoEmissaoTomadorIntermediario: null,
            chaveNfseRejeitada: null,
            substituicao: null,
            prestador: new PrestadorData(
                cnpj: '12345678000199',
                cpf: null,
                nif: null,
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: '12345',
                nome: 'Prestador Teste',
                endereco: new EnderecoData(
                    codigoMunicipio: '1234567',
                    cep: '12345678',
                    logradouro: 'Rua Teste',
                    numero: '100',
                    bairro: 'Centro',
                    complemento: null,
                    enderecoExterior: null
                ),
                telefone: null,
                email: null,
                regimeTributario: null
            ),
            tomador: new TomadorData(
                cpf: null,
                cnpj: null,
                nif: 'NIF123', // Foreign
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: null,
                nome: 'Tomador Estrangeiro',
                endereco: new EnderecoData(
                    codigoMunicipio: null,
                    cep: null,
                    logradouro: null,
                    numero: null,
                    bairro: null,
                    complemento: null,
                    enderecoExterior: null // Missing foreign address
                ),
                telefone: null,
                email: null
            ),
            intermediario: null,
            servico: null,
            valores: null
        )
    );

    $validator = new DpsValidator();
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço no exterior do tomador é obrigatório quando identificado por NIF.');
});

it('fails when Tomador has CPF but missing national address', function () {
    $dps = new DpsData(
        versao: '1.00',
        infDps: new InfDpsData(
            id: 'DPS123',
            tipoAmbiente: 2,
            dataEmissao: '2023-01-01',
            versaoAplicativo: '1.0',
            serie: '1',
            numeroDps: '100',
            dataCompetencia: '2023-01-01',
            tipoEmitente: 1,
            codigoLocalEmissao: '1234567',
            motivoEmissaoTomadorIntermediario: null,
            chaveNfseRejeitada: null,
            substituicao: null,
            prestador: new PrestadorData(
                cnpj: '12345678000199',
                cpf: null,
                nif: null,
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: '12345',
                nome: 'Prestador Teste',
                endereco: new EnderecoData(
                    codigoMunicipio: '1234567',
                    cep: '12345678',
                    logradouro: 'Rua Teste',
                    numero: '100',
                    bairro: 'Centro',
                    complemento: null,
                    enderecoExterior: null
                ),
                telefone: null,
                email: null,
                regimeTributario: null
            ),
            tomador: new TomadorData(
                cpf: '12345678901', // National
                cnpj: null,
                nif: null,
                codigoNaoNif: null,
                caepf: null,
                inscricaoMunicipal: null,
                nome: 'Tomador Nacional',
                endereco: new EnderecoData(
                    codigoMunicipio: null, // Missing cMun
                    cep: null,
                    logradouro: null,
                    numero: null,
                    bairro: null,
                    complemento: null,
                    enderecoExterior: null
                ),
                telefone: null,
                email: null
            ),
            intermediario: null,
            servico: null,
            valores: null
        )
    );

    $validator = new DpsValidator();
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Código do município do tomador é obrigatório para endereço nacional.');
});
