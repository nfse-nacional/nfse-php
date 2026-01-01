<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\DpsData;
use Nfse\Dto\EmitenteData;
use Nfse\Dto\EnderecoEmitenteData;
use Nfse\Dto\InfDpsData;
use Nfse\Dto\InfNfseData;
use Nfse\Dto\NfseData;
use Nfse\Dto\ValoresNfseData;
use Nfse\Xml\NfseXmlBuilder;

it('serializes nfse data to xml correctly', function () {
    $nfse = new NfseData(
        versao: '1.00',
        infNfse: new InfNfseData(
            id: 'NFS123456',
            numeroNfse: '100',
            numeroDfse: '987654321',
            codigoVerificacao: 'ABCDEF',
            dataProcessamento: '2023-01-01T12:00:00',
            ambienteGerador: 2,
            versaoAplicativo: '1.0',
            processoEmissao: 1,
            localEmissao: 'VARZEA ALEGRE',
            localPrestacao: 'VARZEA ALEGRE',
            codigoLocalIncidencia: '2314003',
            nomeLocalIncidencia: 'VARZEA ALEGRE',
            descricaoTributacaoNacional: 'Enfermagem...',
            descricaoTributacaoMunicipal: '04.06 - Enfermagem...',
            codigoStatus: 100,
            dps: new DpsData(
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
                    prestador: null,
                    tomador: null,
                    intermediario: null,
                    servico: null,
                    valores: null
                )
            ),
            emitente: new EmitenteData(
                cnpj: '12345678000199',
                cpf: null,
                inscricaoMunicipal: '12345',
                nome: 'Prefeitura Municipal',
                nomeFantasia: 'Secretaria de Finanças',
                endereco: new EnderecoEmitenteData(
                    logradouro: 'Praça da Sé',
                    numero: '1',
                    complemento: null,
                    bairro: 'Centro',
                    codigoMunicipio: '3550308',
                    uf: 'SP',
                    cep: '01001000'
                ),
                telefone: '1112345678',
                email: 'contato@prefeitura.sp.gov.br'
            ),
            valores: new ValoresNfseData(
                valorCalculadoDeducaoReducao: null,
                tipoBeneficioMunicipal: null,
                valorCalculadoBeneficioMunicipal: null,
                baseCalculo: 1850.00,
                aliquotaAplicada: 5.00,
                valorIssqn: 92.50,
                valorTotalRetido: null,
                valorLiquido: 1757.50
            )
        )
    );

    $builder = new NfseXmlBuilder();
    $xml = $builder->build($nfse);

    expect($xml)->toContain('<NFSe xmlns="http://www.sped.fazenda.gov.br/nfse">')
        ->and($xml)->toContain('<infNFSe Id="NFS123456" versao="1.00">')
        ->and($xml)->toContain('<nNFSe>100</nNFSe>')
        ->and($xml)->toContain('<infDPS Id="DPS123" versao="1.00">')
        ->and($xml)->toContain('<CNPJ>12345678000199</CNPJ>')
        ->and($xml)->toContain('<vLiq>1757.50</vLiq>');
});
