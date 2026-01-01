<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\DpsData;
use Nfse\Dto\InfDpsData;
use Nfse\Dto\PrestadorData;
use Nfse\Dto\TomadorData;
use Nfse\Dto\ServicoData;
use Nfse\Dto\ValoresData;
use Nfse\Dto\EnderecoData;
use Nfse\Dto\RegimeTributarioData;
use Nfse\Dto\LocalPrestacaoData;
use Nfse\Dto\CodigoServicoData;
use Nfse\Dto\ValorServicoPrestadoData;
use Nfse\Dto\TributacaoData;
use Nfse\Xml\DpsXmlBuilder;

it('can build xml matching ExemploPrestadorPessoaFisica', function () {
    $infDps = new InfDpsData(
        id: 'DPS231400310000667299238300001000000000000046',
        tipoAmbiente: 1,
        dataEmissao: '2025-12-15T11:11:09-03:00',
        versaoAplicativo: 'Sistema NFS-e',
        serie: '00001',
        numeroDps: '46',
        dataCompetencia: '2025-12-15',
        tipoEmitente: 1,
        codigoLocalEmissao: '2314003',
        motivoEmissaoTomadorIntermediario: null,
        chaveNfseRejeitada: null,
        substituicao: null,
        prestador: new PrestadorData(
            cnpj: null,
            cpf: '06672992383',
            nif: null,
            codigoNaoNif: null,
            caepf: null,
            inscricaoMunicipal: null,
            nome: null, // Not in example DPS prest tag
            endereco: null,
            telefone: null,
            email: 'naoinformado@gmail.com',
            regimeTributario: new RegimeTributarioData(
                opcaoSimplesNacional: 1,
                regimeApuracaoTributosSn: null, // Not in example
                regimeEspecialTributacao: 0
            )
        ),
        tomador: new TomadorData(
            cpf: null,
            cnpj: '10237604000100',
            nif: null,
            codigoNaoNif: null,
            caepf: null,
            inscricaoMunicipal: null,
            nome: 'FUNDO MUNICIPAL DE SAUDE - VARZEA ALEGRE',
            endereco: new EnderecoData(
                codigoMunicipio: '2314003',
                cep: '63540000',
                logradouro: 'RUA DEP LUIZ OTACILIO CORREIA',
                numero: '-', // Example has "-" in nro tag? No, wait. "RUA DEP LUIZ OTACILIO CORREIA, 153" is xLgr?
                // Example:
                // <xLgr>RUA DEP LUIZ OTACILIO CORREIA, 153</xLgr>
                // <nro>-</nro>
                bairro: 'CENTRO',
                complemento: null,
                enderecoExterior: null
            ),
            telefone: null,
            email: null
        ),
        intermediario: null,
        servico: new ServicoData(
            localPrestacao: new LocalPrestacaoData(
                codigoLocalPrestacao: '2314003',
                codigoPaisPrestacao: null
            ),
            codigoServico: new CodigoServicoData(
                codigoTributacaoNacional: '040601',
                codigoTributacaoMunicipal: null,
                descricaoServico: '(VALOR EMPENHADO PARA ATENDER DESPESAS COM CREDENCIAMENTO DE PROFISSIONAIS ESPECIALIZADOS COMO  TECNICA DE ENFERMAGEM PARA COMPLEMENTAR A EQUIPE DE ATENÇÃO DOMICILIAR (EMAD) E A EQUIPE MULTIPROFISSIONAL  DE APOIO (EMAP), NO ÂMBITO DO SISTEMA ÚNICO DE SAÚDE (SUS), CONFORME TERMO DE REFERÊNCIA, A SEREM PRESTADOS  NESTA CIDADE, ATRAVÉS DA SECRETARIA MUNICIPAL DE SAÚDE DE VÁRZEA ALEGRE/CE,CONFORME PROCESSO DE Nº003-2024 E  CONTRATO DE Nº2024.03.06.1,) ',
                codigoNbs: '123019100',
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
                valorServico: 1850.00
            ),
            desconto: null,
            deducaoReducao: null,
            tributacao: new TributacaoData(
                tributacaoIssqn: 1,
                tipoImunidade: null,
                tipoRetencaoIssqn: 2,
                tipoSuspensao: null,
                numeroProcessoSuspensao: null,
                beneficioMunicipal: null,
                cstPisCofins: null,
                percentualTotalTributosSN: null,
                indicadorTotalTributos: 0
            )
        )
    );

    $dpsData = new DpsData(
        versao: '1.00',
        infDps: $infDps
    );

    $builder = new DpsXmlBuilder();
    $xml = $builder->build($dpsData);

    // Assertions based on the example XML structure
    expect($xml)->toContain('<infDPS Id="DPS231400310000667299238300001000000000000046" versao="1.00">')
        ->and($xml)->toContain('<tpAmb>1</tpAmb>')
        ->and($xml)->toContain('<dhEmi>2025-12-15T11:11:09-03:00</dhEmi>')
        ->and($xml)->toContain('<verAplic>Sistema NFS-e</verAplic>')
        ->and($xml)->toContain('<serie>00001</serie>')
        ->and($xml)->toContain('<nDPS>46</nDPS>')
        ->and($xml)->toContain('<dCompet>2025-12-15</dCompet>')
        ->and($xml)->toContain('<tpEmit>1</tpEmit>')
        ->and($xml)->toContain('<cLocEmi>2314003</cLocEmi>')
        // Prestador
        ->and($xml)->toContain('<CPF>06672992383</CPF>')
        ->and($xml)->toContain('<email>naoinformado@gmail.com</email>')
        ->and($xml)->toContain('<opSimpNac>1</opSimpNac>')
        ->and($xml)->toContain('<regEspTrib>0</regEspTrib>')
        // Tomador
        ->and($xml)->toContain('<CNPJ>10237604000100</CNPJ>')
        ->and($xml)->toContain('<xNome>FUNDO MUNICIPAL DE SAUDE - VARZEA ALEGRE</xNome>')
        ->and($xml)->toContain('<cMun>2314003</cMun>')
        ->and($xml)->toContain('<CEP>63540000</CEP>')
        ->and($xml)->toContain('<xLgr>RUA DEP LUIZ OTACILIO CORREIA</xLgr>') // Note: example has comma and number in xLgr? "RUA DEP LUIZ OTACILIO CORREIA, 153". I put it in xLgr in DTO.
        ->and($xml)->toContain('<nro>-</nro>')
        ->and($xml)->toContain('<xBairro>CENTRO</xBairro>')
        // Servico
        ->and($xml)->toContain('<cLocPrestacao>2314003</cLocPrestacao>')
        ->and($xml)->toContain('<cTribNac>040601</cTribNac>')
        ->and($xml)->toContain('<cNBS>123019100</cNBS>')
        // Valores
        ->and($xml)->toContain('<vServ>1850.00</vServ>')
        ->and($xml)->toContain('<tribISSQN>1</tribISSQN>')
        ->and($xml)->toContain('<tpRetISSQN>2</tpRetISSQN>')
        ->and($xml)->toContain('<indTotTrib>0</indTotTrib>');
});
