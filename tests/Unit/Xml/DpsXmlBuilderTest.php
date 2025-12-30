<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Nfse\Dto\DpsData;
use Nfse\Nfse\Dto\InfDpsData;
use Nfse\Nfse\Dto\PrestadorData;
use Nfse\Nfse\Dto\TomadorData;
use Nfse\Nfse\Dto\ServicoData;
use Nfse\Nfse\Dto\ValoresData;
use Nfse\Nfse\Dto\LocalPrestacaoData;
use Nfse\Nfse\Dto\CodigoServicoData;
use Nfse\Nfse\Dto\ValorServicoPrestadoData;
use Nfse\Nfse\Dto\TributacaoData;
use Nfse\Nfse\Xml\DpsXmlBuilder;

it('can build xml from dps data', function () {
    $infDps = new InfDpsData(
        id: 'DPS123',
        tipoAmbiente: 2,
        dataEmissao: '2023-10-27T10:00:00',
        versaoAplicativo: '1.0',
        serie: '1',
        numeroDps: '1001',
        dataCompetencia: '2023-10-27',
        tipoEmitente: 1,
        codigoLocalEmissao: '3550308',
        motivoEmissaoTomadorIntermediario: '4',
        chaveNfseRejeitada: '12345678901234567890123456789012345678901234',
        substituicao: null,
        prestador: new PrestadorData(
            cnpj: '12345678000199',
            cpf: null,
            nif: null,
            codigoNaoNif: null,
            caepf: null,
            inscricaoMunicipal: '12345',
            nome: 'Prestador Exemplo Ltda',
            endereco: null,
            telefone: null,
            email: null,
            regimeTributario: null
        ),
        tomador: new TomadorData(
            cpf: '11122233344',
            cnpj: null,
            nif: null,
            codigoNaoNif: null,
            caepf: null,
            inscricaoMunicipal: null,
            nome: 'Tomador Exemplo',
            endereco: null,
            telefone: null,
            email: null
        ),
        intermediario: null,
        servico: new ServicoData(
            localPrestacao: new LocalPrestacaoData(
                codigoLocalPrestacao: '3550308',
                codigoPaisPrestacao: 'BR'
            ),
            codigoServico: new CodigoServicoData(
                codigoTributacaoNacional: '1.01',
                codigoTributacaoMunicipal: null,
                descricaoServico: 'Analise de sistemas',
                codigoNbs: null,
                codigoInternoContribuinte: null
            ),
            comercioExterior: null,
            obra: null,
            atividadeEvento: null,
            informacoesComplementares: null,
            idDocumentoTecnico: null,
            documentoReferencia: null,
            descricaoInformacoesComplementares: null
        ),
        valores: new ValoresData(
            valorServicoPrestado: new ValorServicoPrestadoData(
                valorRecebido: 1000.00,
                valorServico: 1000.00
            ),
            desconto: null,
            deducaoReducao: null,
            tributacao: new TributacaoData(
                tributacaoIssqn: 1,
                tipoImunidade: null,
                tipoRetencaoIssqn: 1,
                tipoSuspensao: 1,
                numeroProcessoSuspensao: '123456',
                beneficioMunicipal: new \Nfse\Nfse\Dto\BeneficioMunicipalData(
                    percentualReducaoBcBm: 10.0,
                    valorReducaoBcBm: 100.0
                ),
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

    $builder = new DpsXmlBuilder();
    $xml = $builder->build($dpsData);

    expect($xml)->toContain('<DPS xmlns="http://www.sped.fazenda.gov.br/nfse">')
        ->and($xml)->toContain('<infDPS Id="DPS123" versao="1.0">')
        ->and($xml)->toContain('<nDPS>1001</nDPS>')
        ->and($xml)->toContain('<vServ>1000.00</vServ>')
        ->and($xml)->toContain('<cMotivoEmisTI>4</cMotivoEmisTI>')
        ->and($xml)->toContain('<chNFSeRej>12345678901234567890123456789012345678901234</chNFSeRej>')
        ->and($xml)->toContain('<tpSusp>1</tpSusp>')
        ->and($xml)->toContain('<nProcesso>123456</nProcesso>')
        ->and($xml)->toContain('<pRedBCBM>10.00</pRedBCBM>')
        ->and($xml)->toContain('<vRedBCBM>100.00</vRedBCBM>');
});
