<?php

namespace Nfse\Tests\Unit\Dto;

use Nfse\Dto\DpsData;
use Nfse\Dto\EmitenteData;
use Nfse\Dto\EnderecoData;
use Nfse\Dto\EnderecoEmitenteData;
use Nfse\Dto\InfDpsData;
use Nfse\Dto\InfNfseData;
use Nfse\Dto\NfseData;
use Nfse\Dto\PrestadorData;
use Nfse\Dto\RegimeTributarioData;
use Nfse\Dto\ServicoData;
use Nfse\Dto\TomadorData;
use Nfse\Dto\TributacaoData;
use Nfse\Dto\ValoresData;
use Nfse\Dto\ValoresNfseData;
use Nfse\Dto\ValorServicoPrestadoData;
use Nfse\Dto\LocalPrestacaoData;
use Nfse\Dto\CodigoServicoData;
use Nfse\Xml\NfseXmlBuilder;
use Nfse\Support\IdGenerator;

it('can generate XML with all fields from ExemploPisZeradoCofinsSobreFaturamentoPreenchido', function () {
    $dpsId = IdGenerator::generateDpsId('11905971000105', '3304557', '333', '6');

    // Construct the DTO based on the XML example
    $nfse = new NfseData(
        versao: '1.01',
        infNfse: new InfNfseData(
            id: 'NFS33045572211905971000105000000000014625124504258429',
            numeroNfse: '146',
            numeroDfse: '60631',
            codigoVerificacao: null, // Not present in the example XML snippet provided in the test file context, but usually present. The example shows <nDFSe>60631</nDFSe> but no <cVerif>.
            dataProcessamento: '2025-12-30T19:01:35-03:00',
            ambienteGerador: 2,
            versaoAplicativo: 'SefinNac_Pre_1.4.0',
            processoEmissao: 1,
            localEmissao: 'Rio de Janeiro',
            localPrestacao: 'Rio de Janeiro',
            codigoLocalIncidencia: '3304557',
            nomeLocalIncidencia: 'Rio de Janeiro',
            descricaoTributacaoNacional: 'Análise e desenvolvimento de sistemas.',
            descricaoTributacaoMunicipal: 'Análise de sistemas.',
            descricaoNbs: 'Serviços de projeto, desenvolvimento e instalação de aplicativos e programas não personalizados (não customizados)',
            tipoEmissao: 1,
            codigoStatus: 100,
            outrasInformacoes: null,
            dps: new DpsData(
                versao: '1.01',
                infDps: new InfDpsData(
                    id: $dpsId,
                    tipoAmbiente: 2,
                    dataEmissao: '2025-12-30T19:00:06-03:00',
                    versaoAplicativo: 'MXM.RTC-1.00',
                    serie: '333',
                    numeroDps: '6',
                    dataCompetencia: '2025-12-30',
                    tipoEmitente: 1,
                    codigoLocalEmissao: '3304557',
                    motivoEmissaoTomadorIntermediario: null,
                    chaveNfseRejeitada: null,
                    substituicao: null,
                    prestador: new PrestadorData(
                        cnpj: '11905971000105',
                        cpf: null,
                        nif: null,
                        codigoNaoNif: null,
                        caepf: null,
                        inscricaoMunicipal: null,
                        nome: null,
                        endereco: null,
                        telefone: '3132332300',
                        email: 'sau@mxm.com.br',
                        regimeTributario: new RegimeTributarioData(
                            opcaoSimplesNacional: 3,
                            regimeApuracaoTributosSn: 3,
                            regimeEspecialTributacao: 0
                        )
                    ),
                    tomador: new TomadorData(
                        cpf: null,
                        cnpj: '39847728000199',
                        nif: null,
                        codigoNaoNif: null,
                        caepf: null,
                        inscricaoMunicipal: null,
                        nome: 'MXM & JETTAX',
                        endereco: new EnderecoData(
                            codigoMunicipio: '3303302',
                            cep: '24020077',
                            logradouro: 'AV RIO BRANCO',
                            numero: '123',
                            bairro: 'CENTRO',
                            complemento: null,
                            enderecoExterior: null
                        ),
                        telefone: '2132332300',
                        email: 'SAU@mxm.com.br'
                    ),
                    intermediario: null,
                    servico: new ServicoData(
                        localPrestacao: new LocalPrestacaoData(
                            codigoLocalPrestacao: '3304557',
                            codigoPaisPrestacao: null
                        ),
                        codigoServico: new CodigoServicoData(
                            codigoTributacaoNacional: '010101',
                            codigoTributacaoMunicipal: '001',
                            descricaoServico: 'Analise e desenvolvimento de sistemas (MXM)',
                            codigoNbs: '115021000',
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
                            valorRecebido: null,
                            valorServico: 10000.00
                        ),
                        desconto: null,
                        deducaoReducao: null,
                        tributacao: new TributacaoData(
                            tributacaoIssqn: 1,
                            tipoImunidade: null,
                            tipoRetencaoIssqn: 1,
                            tipoSuspensao: null,
                            numeroProcessoSuspensao: null,
                            beneficioMunicipal: null,
                            cstPisCofins: '01',
                            baseCalculoPisCofins: 10000.00,
                            aliquotaPis: 0.00,
                            aliquotaCofins: 7.60,
                            valorPis: 0.00,
                            valorCofins: 760.00,
                            tipoRetencaoPisCofins: 2,
                            valorRetidoIrrf: 150.00,
                            valorRetidoCsll: 465.00,
                            valorTotalTributosFederais: 760.00,
                            valorTotalTributosEstaduais: 0.00,
                            valorTotalTributosMunicipais: 500.00,
                            percentualTotalTributosSN: null,
                            indicadorTotalTributos: null
                        )
                    )
                )
            ),
            emitente: new EmitenteData(
                cnpj: '11905971000105',
                cpf: null,
                inscricaoMunicipal: null,
                nome: 'GUIDI SISTEMAS E SERVICOS EM TECNOLOGIA DA INFORMACAO LTDA',
                nomeFantasia: null,
                endereco: new EnderecoEmitenteData(
                    logradouro: 'GUANDU DO SAPE',
                    numero: '01450',
                    complemento: null,
                    bairro: 'CAMPO GRANDE',
                    codigoMunicipio: '3304557',
                    uf: 'RJ',
                    cep: '23095072'
                ),
                telefone: '2135933387',
                email: 'VANDERSON@GUIDISISTEMAS.COM.BR'
            ),
            valores: new ValoresNfseData(
                valorCalculadoDeducaoReducao: null,
                tipoBeneficioMunicipal: null,
                valorCalculadoBeneficioMunicipal: null,
                baseCalculo: 10000.00,
                aliquotaAplicada: 5.00,
                valorIssqn: 500.00,
                valorTotalRetido: 615.00,
                valorLiquido: 9385.00
            )
        )
    );

    $builder = new NfseXmlBuilder();
    $xml = $builder->build($nfse);

    // Assertions for NFSe fields
    expect($xml)->toContain('Id="NFS33045572211905971000105000000000014625124504258429"')
        ->and($xml)->toContain('<xLocEmi>Rio de Janeiro</xLocEmi>')
        ->and($xml)->toContain('<xLocPrestacao>Rio de Janeiro</xLocPrestacao>')
        ->and($xml)->toContain('<nNFSe>146</nNFSe>')
        ->and($xml)->toContain('<cLocIncid>3304557</cLocIncid>')
        ->and($xml)->toContain('<xLocIncid>Rio de Janeiro</xLocIncid>')
        ->and($xml)->toContain('<xTribNac>Análise e desenvolvimento de sistemas.</xTribNac>')
        ->and($xml)->toContain('<xTribMun>Análise de sistemas.</xTribMun>')
        ->and($xml)->toContain('<xNBS>Serviços de projeto, desenvolvimento e instalação de aplicativos e programas não personalizados (não customizados)</xNBS>')
        ->and($xml)->toContain('<verAplic>SefinNac_Pre_1.4.0</verAplic>')
        ->and($xml)->toContain('<ambGer>2</ambGer>')
        ->and($xml)->toContain('<tpEmis>1</tpEmis>')
        ->and($xml)->toContain('<procEmi>1</procEmi>')
        ->and($xml)->toContain('<cStat>100</cStat>')
        ->and($xml)->toContain('<dhProc>2025-12-30T19:01:35-03:00</dhProc>')
        ->and($xml)->toContain('<nDFSe>60631</nDFSe>');

    // Assertions for Emitente
    expect($xml)->toContain('<CNPJ>11905971000105</CNPJ>')
        ->and($xml)->toContain('<xNome>GUIDI SISTEMAS E SERVICOS EM TECNOLOGIA DA INFORMACAO LTDA</xNome>')
        ->and($xml)->toContain('<xLgr>GUANDU DO SAPE</xLgr>')
        ->and($xml)->toContain('<nro>01450</nro>')
        ->and($xml)->toContain('<xBairro>CAMPO GRANDE</xBairro>')
        ->and($xml)->toContain('<cMun>3304557</cMun>')
        ->and($xml)->toContain('<UF>RJ</UF>')
        ->and($xml)->toContain('<CEP>23095072</CEP>')
        ->and($xml)->toContain('<fone>2135933387</fone>')
        ->and($xml)->toContain('<email>VANDERSON@GUIDISISTEMAS.COM.BR</email>');

    // Assertions for Valores NFSe
    expect($xml)->toContain('<vBC>10000.00</vBC>')
        ->and($xml)->toContain('<pAliqAplic>5.00</pAliqAplic>')
        ->and($xml)->toContain('<vISSQN>500.00</vISSQN>')
        ->and($xml)->toContain('<vTotalRet>615.00</vTotalRet>')
        ->and($xml)->toContain('<vLiq>9385.00</vLiq>');

    // Assertions for DPS fields
    expect($xml)->toContain('Id="' . $dpsId . '"')
        ->and($xml)->toContain('<tpAmb>2</tpAmb>')
        ->and($xml)->toContain('<dhEmi>2025-12-30T19:00:06-03:00</dhEmi>')
        ->and($xml)->toContain('<verAplic>MXM.RTC-1.00</verAplic>')
        ->and($xml)->toContain('<serie>333</serie>')
        ->and($xml)->toContain('<nDPS>6</nDPS>')
        ->and($xml)->toContain('<dCompet>2025-12-30</dCompet>')
        ->and($xml)->toContain('<tpEmit>1</tpEmit>')
        ->and($xml)->toContain('<cLocEmi>3304557</cLocEmi>');

    // Assertions for Prestador
    expect($xml)->toContain('<CNPJ>11905971000105</CNPJ>')
        ->and($xml)->toContain('<fone>3132332300</fone>')
        ->and($xml)->toContain('<email>sau@mxm.com.br</email>')
        ->and($xml)->toContain('<opSimpNac>3</opSimpNac>')
        ->and($xml)->toContain('<regApTribSN>3</regApTribSN>')
        ->and($xml)->toContain('<regEspTrib>0</regEspTrib>');

    // Assertions for Tomador
    expect($xml)->toContain('<CNPJ>39847728000199</CNPJ>')
        ->and($xml)->toContain('<xNome>MXM &amp; JETTAX</xNome>')
        ->and($xml)->toContain('<cMun>3303302</cMun>')
        ->and($xml)->toContain('<CEP>24020077</CEP>')
        ->and($xml)->toContain('<xLgr>AV RIO BRANCO</xLgr>')
        ->and($xml)->toContain('<nro>123</nro>')
        ->and($xml)->toContain('<xBairro>CENTRO</xBairro>')
        ->and($xml)->toContain('<fone>2132332300</fone>')
        ->and($xml)->toContain('<email>SAU@mxm.com.br</email>');

    // Assertions for Servico
    expect($xml)->toContain('<cLocPrestacao>3304557</cLocPrestacao>')
        ->and($xml)->toContain('<cTribNac>010101</cTribNac>')
        ->and($xml)->toContain('<cTribMun>001</cTribMun>')
        ->and($xml)->toContain('<xDescServ>Analise e desenvolvimento de sistemas (MXM)</xDescServ>')
        ->and($xml)->toContain('<cNBS>115021000</cNBS>');

    // Assertions for Valores DPS
    expect($xml)->toContain('<vServ>10000.00</vServ>')
        ->and($xml)->toContain('<tribISSQN>1</tribISSQN>')
        ->and($xml)->toContain('<tpRetISSQN>1</tpRetISSQN>')
        ->and($xml)->toContain('<CST>01</CST>')
        ->and($xml)->toContain('<vBCPisCofins>10000.00</vBCPisCofins>')
        ->and($xml)->toContain('<pAliqPis>0.00</pAliqPis>')
        ->and($xml)->toContain('<pAliqCofins>7.60</pAliqCofins>')
        ->and($xml)->toContain('<vPis>0.00</vPis>')
        ->and($xml)->toContain('<vCofins>760.00</vCofins>')
        ->and($xml)->toContain('<tpRetPisCofins>2</tpRetPisCofins>')
        ->and($xml)->toContain('<vRetIRRF>150.00</vRetIRRF>')
        ->and($xml)->toContain('<vRetCSLL>465.00</vRetCSLL>')
        ->and($xml)->toContain('<vTotTribFed>760.00</vTotTribFed>')
        ->and($xml)->toContain('<vTotTribEst>0.00</vTotTribEst>')
        ->and($xml)->toContain('<vTotTribMun>500.00</vTotTribMun>');
});
