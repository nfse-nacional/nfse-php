<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\RegimeTributarioData;
use Nfse\Dto\Nfse\IntermediarioData;
use Nfse\Dto\Nfse\SubstituicaoData;
use Nfse\Dto\Nfse\ComercioExteriorData;
use Nfse\Dto\Nfse\ObraData;
use Nfse\Dto\Nfse\AtividadeEventoData;
use Nfse\Dto\Nfse\ValoresData;
use Nfse\Dto\Nfse\DescontoData;
use Nfse\Dto\Nfse\DeducaoReducaoData;
use Nfse\Dto\Nfse\DocumentoDeducaoData;
use Nfse\Dto\Nfse\TributacaoData;
use Nfse\Dto\Nfse\EnderecoData;
use Nfse\Xml\DpsXmlBuilder;

it('can build xml with complex structures', function () {
    $infDps = new InfDpsData(
        id: 'DPS123',
        tipoAmbiente: 2,
        dataEmissao: '2023-10-27T10:00:00',
        versaoAplicativo: '1.0',
        serie: '1',
        numeroDps: '1',
        dataCompetencia: '2023-10-27',
        tipoEmitente: 1,
        codigoLocalEmissao: '3550308',
        substituicao: new SubstituicaoData(
            chaveNfseSubstituida: '12345678901234567890123456789012345678901234',
            codigoMotivo: '1',
            descricaoMotivo: 'Erro no valor'
        ),
        prestador: new PrestadorData(
            cnpj: '12345678000199',
            nome: 'Prestador',
            regimeTributario: new RegimeTributarioData(
                opcaoSimplesNacional: 1,
                regimeApuracaoTributosSn: 1,
                regimeEspecialTributacao: 1
            )
        ),
        intermediario: new IntermediarioData(
            cnpj: '88888888000188',
            nome: 'Intermediario',
            endereco: new EnderecoData(
                logradouro: 'Rua Inter',
                numero: '100',
                bairro: 'Centro',
                codigoMunicipio: '3550308',
                cep: '01001000'
            )
        ),
        servico: new \Nfse\Dto\Nfse\ServicoData(
            comercioExterior: new ComercioExteriorData(
                modoPrestacao: 1,
                vinculoPrestacao: 1,
                tipoPessoaExportador: 1,
                nifExportador: null,
                codigoPaisExportador: null,
                codigoMecanismoApoioFomento: null,
                numeroEnquadramento: null,
                numeroProcesso: null,
                indicadorIncentivo: null,
                descricaoIncentivo: null,
                tipoMoeda: 'USD',
                valorServicoMoeda: 100.00,
                mecanismoApoioComexPrestador: null,
                mecanismoApoioComexTomador: null,
                movimentacaoTemporariaBens: null,
                numeroDeclaracaoImportacao: null,
                numeroRegistroExportacao: null,
                mdic: null
            ),
            obra: new ObraData(
                inscricaoImobiliariaFiscal: '123',
                codigoObra: '456',
                endereco: new EnderecoData(
                    logradouro: 'Rua Obra',
                    numero: '200',
                    bairro: 'Obra',
                    codigoMunicipio: '3550308',
                    cep: '01001000'
                )
            ),
            atividadeEvento: new AtividadeEventoData(
                nome: 'Evento',
                dataInicio: '2023-10-27',
                dataFim: '2023-10-28',
                idAtividadeEvento: 'EVT123',
                endereco: null
            )
        ),
        valores: new ValoresData(
            valorServicoPrestado: new \Nfse\Dto\Nfse\ValorServicoPrestadoData(100.0, 100.0),
            desconto: new DescontoData(
                valorDescontoIncondicionado: 10.0,
                valorDescontoCondicionado: 5.0
            ),
            deducaoReducao: new DeducaoReducaoData(
                percentualDeducaoReducao: 20.0,
                valorDeducaoReducao: 200.0,
                documentos: [
                    new DocumentoDeducaoData(
                        chaveNfse: '12345678901234567890123456789012345678901234',
                        chaveNfe: null,
                        tipoDeducaoReducao: 1,
                        descricaoOutrasDeducoes: null,
                        dataEmissaoDocumento: null,
                        valorDedutivelRedutivel: 100.0,
                        valorDeducaoReducao: 100.0
                    )
                ]
            ),
            tributacao: new TributacaoData(
                tributacaoIssqn: 1,
                tipoImunidade: null,
                tipoRetencaoIssqn: 1,
                tipoSuspensao: null,
                numeroProcessoSuspensao: null,
                beneficioMunicipal: null,
                cstPisCofins: '01',
                baseCalculoPisCofins: 1000.0,
                aliquotaPis: 0.65,
                aliquotaCofins: 3.0,
                valorPis: 6.5,
                valorCofins: 30.0,
                tipoRetencaoPisCofins: 1,
                valorRetidoIrrf: 15.0,
                valorRetidoCsll: 10.0,
                valorTotalTributosFederais: 50.0,
                valorTotalTributosEstaduais: 20.0,
                valorTotalTributosMunicipais: 30.0
            )
        )
    );

    $dpsData = new DpsData(versao: '1.0', infDps: $infDps);
    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<subst>')
        ->and($xml)->toContain('<chSubstda>12345678901234567890123456789012345678901234</chSubstda>')
        ->and($xml)->toContain('<regTrib>')
        ->and($xml)->toContain('<interm>')
        ->and($xml)->toContain('<comExt>')
        ->and($xml)->toContain('<obra>')
        ->and($xml)->toContain('<atvEvento>')
        ->and($xml)->toContain('<vDescCondIncond>')
        ->and($xml)->toContain('<vDedRed>')
        ->and($xml)->toContain('<documentos>')
        ->and($xml)->toContain('<piscofins>')
        ->and($xml)->toContain('<vRetIRRF>15.00</vRetIRRF>')
        ->and($xml)->toContain('<vRetCSLL>10.00</vRetCSLL>')
        ->and($xml)->toContain('<vTotTribFed>50.00</vTotTribFed>');
});

it('can build xml with indicadorTotalTributos', function () {
    $infDps = new InfDpsData(
        id: 'DPS123',
        tipoAmbiente: 2,
        dataEmissao: '2023-10-27T10:00:00',
        versaoAplicativo: '1.0',
        serie: '1',
        numeroDps: '1',
        dataCompetencia: '2023-10-27',
        tipoEmitente: 1,
        codigoLocalEmissao: '3550308',
        valores: new ValoresData(
            valorServicoPrestado: new \Nfse\Dto\Nfse\ValorServicoPrestadoData(100.0, 100.0),
            tributacao: new TributacaoData(
                tributacaoIssqn: 1,
                tipoImunidade: null,
                tipoRetencaoIssqn: null,
                tipoSuspensao: null,
                numeroProcessoSuspensao: null,
                beneficioMunicipal: null,
                cstPisCofins: null,
                indicadorTotalTributos: 1
            )
        )
    );

    $dpsData = new DpsData(versao: '1.0', infDps: $infDps);
    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<indTotTrib>1</indTotTrib>');
});

it('can build xml with percentualTotalTributosSN', function () {
    $infDps = new InfDpsData(
        id: 'DPS123',
        tipoAmbiente: 2,
        dataEmissao: '2023-10-27T10:00:00',
        versaoAplicativo: '1.0',
        serie: '1',
        numeroDps: '1',
        dataCompetencia: '2023-10-27',
        tipoEmitente: 1,
        codigoLocalEmissao: '3550308',
        valores: new ValoresData(
            valorServicoPrestado: new \Nfse\Dto\Nfse\ValorServicoPrestadoData(100.0, 100.0),
            tributacao: new TributacaoData(
                tributacaoIssqn: 1,
                tipoImunidade: null,
                tipoRetencaoIssqn: null,
                tipoSuspensao: null,
                numeroProcessoSuspensao: null,
                beneficioMunicipal: null,
                cstPisCofins: null,
                percentualTotalTributosSN: 5.0
            )
        )
    );

    $dpsData = new DpsData(versao: '1.0', infDps: $infDps);
    $builder = new DpsXmlBuilder;
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<pTotTribSN>5.00</pTotTribSN>');
});
