<?php

namespace Nfse\Tests\Unit\Dto;

use Nfse\Dto\DpsData;
use Nfse\Dto\InfDpsData;
use Nfse\Dto\PrestadorData;
use Nfse\Dto\TomadorData;
use Nfse\Dto\ServicoData;
use Nfse\Dto\ValoresData;
use Nfse\Dto\EnderecoData;
use Nfse\Dto\RegimeTributarioData;
use Nfse\Dto\TributacaoData;
use Nfse\Dto\LocalPrestacaoData;
use Nfse\Dto\CodigoServicoData;
use Nfse\Dto\ValorServicoPrestadoData;
use Nfse\Dto\DescontoData;
use Nfse\Support\IdGenerator;

it('can instantiate dps data with full structure', function () {
    $id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

    $infDps = new InfDpsData(
        id: $id,
        tipoAmbiente: 2,
        dataEmissao: '2023-10-27T10:00:00',
        versaoAplicativo: '1.0',
        serie: '1',
        numeroDps: '1001',
        dataCompetencia: '2023-10-27',
        tipoEmitente: 1,
        codigoLocalEmissao: '3550308',
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
            nome: 'Prestador Exemplo Ltda',
            endereco: new EnderecoData(
                codigoMunicipio: '3550308',
                cep: '01001000',
                logradouro: 'Exemplo',
                numero: '100',
                bairro: 'Centro',
                complemento: 'Apto 1',
                enderecoExterior: null
            ),
            telefone: '11999999999',
            email: 'prestador@example.com',
            regimeTributario: new RegimeTributarioData(
                opcaoSimplesNacional: 1,
                regimeApuracaoTributosSn: 0,
                regimeEspecialTributacao: 0
            )
        ),
        tomador: new TomadorData(
            cpf: '11122233344',
            cnpj: null,
            nif: null,
            codigoNaoNif: null,
            caepf: null,
            inscricaoMunicipal: null,
            nome: 'Tomador Exemplo',
            endereco: new EnderecoData(
                codigoMunicipio: '3550308',
                cep: '01002000',
                logradouro: 'Brasil',
                numero: '200',
                bairro: 'Jardins',
                complemento: null,
                enderecoExterior: null
            ),
            telefone: '11888888888',
            email: 'tomador@example.com'
        ),
        intermediario: null,
        servico: new ServicoData(
            localPrestacao: new LocalPrestacaoData(
                codigoLocalPrestacao: '3550308',
                codigoPaisPrestacao: 'BR'
            ),
            codigoServico: new CodigoServicoData(
                codigoTributacaoNacional: '1.01',
                codigoTributacaoMunicipal: '1010',
                descricaoServico: 'Analise de sistemas',
                codigoNbs: '1234',
                codigoInternoContribuinte: 'SERV001'
            ),
            comercioExterior: null,
            obra: null,
            atividadeEvento: null,
            informacoesComplementares: 'Serviço prestado com excelência',
            idDocumentoTecnico: null,
            documentoReferencia: null,
            descricaoInformacoesComplementares: null
        ),
        valores: new ValoresData(
            valorServicoPrestado: new ValorServicoPrestadoData(
                valorRecebido: 1000.00,
                valorServico: 1000.00
            ),
            desconto: new DescontoData(
                valorDescontoIncondicionado: 0.0,
                valorDescontoCondicionado: 0.0
            ),
            deducaoReducao: null,
            tributacao: new TributacaoData(
                tributacaoIssqn: 1,
                tipoImunidade: null,
                tipoRetencaoIssqn: 1,
                tipoSuspensao: null,
                numeroProcessoSuspensao: null,
                beneficioMunicipal: null,
                cstPisCofins: null,
                percentualTotalTributosSN: null,
                indicadorTotalTributos: null
            )
        )
    );

    $dpsData = new DpsData(
        versao: '1.0',
        infDps: $infDps
    );

    expect($dpsData)->toBeInstanceOf(DpsData::class)
        ->and($dpsData->infDps->id)->toBe($id)
        ->and($dpsData->infDps->prestador->cnpj)->toBe('12345678000199');
});
