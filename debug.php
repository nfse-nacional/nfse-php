<?php

require __DIR__.'/vendor/autoload.php';

use Nfse\Dto\Nfse\CodigoServicoData;
use Nfse\Dto\Nfse\DescontoData;
use Nfse\Dto\Nfse\EnderecoData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Dto\Nfse\IntermediarioData;
use Nfse\Dto\Nfse\LocalPrestacaoData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\RegimeTributarioData;
use Nfse\Dto\Nfse\ServicoData;
use Nfse\Dto\Nfse\SubstituicaoData;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Dto\Nfse\TributacaoData;
use Nfse\Dto\Nfse\ValoresData;
use Nfse\Dto\Nfse\ValorServicoPrestadoData;

try {
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
        substituicao: new SubstituicaoData(
            chaveSubstituida: 'NFS123',
            codigoMotivo: '01',
            descricaoMotivo: 'Erro de preenchimento'
        ),
        prestador: new PrestadorData(
            cnpj: '12345678000199',
            cpf: null,
            nif: null,
            codigoNaoNif: null,
            caepf: null,
            inscricaoMunicipal: '12345',
            nome: 'Prestador Exemplo Ltda',
            endereco: new EnderecoData(
                logradouro: 'Exemplo',
                numero: '100',
                bairro: 'Centro',
                codigoMunicipio: '3550308',
                cep: '01001000'
            ),
            telefone: '11999999999',
            email: 'prestador@example.com',
            regimeTributario: new RegimeTributarioData(
                opcaoSimplesNacional: 1,
                regimeApuracaoTributariaSN: 0,
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
                logradouro: 'Brasil',
                numero: '200',
                bairro: 'Jardins',
                codigoMunicipio: '3550308',
                cep: '01002000'
            ),
            telefone: '11888888888',
            email: 'tomador@example.com'
        ),
        intermediario: new IntermediarioData(
            cnpj: '98765432000100',
            cpf: null,
            nif: null,
            codigoNaoNif: null,
            caepf: null,
            inscricaoMunicipal: '54321',
            nome: 'Intermediario Ltda',
            endereco: new EnderecoData(
                logradouro: 'Meio',
                numero: '50',
                bairro: 'Centro',
                codigoMunicipio: '3550308',
                cep: '01003000'
            ),
            telefone: '11777777777',
            email: 'interm@example.com'
        ),
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
            ajusteBaseCalculo: null,
            tributacao: new TributacaoData(
                tributacaoIssqn: 1,
                tipoRetencaoIssqn: 1,
                cstPisCofins: null,
                percentualTotalTributosSN: null
            )
        )
    );

    echo "InfDpsData created successfully!\n";
    var_dump($infDps);

} catch (\Throwable $e) {
    echo 'Error: '.$e->getMessage()."\n";
    echo $e->getTraceAsString();
}
