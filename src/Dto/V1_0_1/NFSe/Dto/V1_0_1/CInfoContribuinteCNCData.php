<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CInfoContribuinteCNCData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCInfoContribuinteCNC
 */
class CInfoContribuinteCNCData 
{
    /**
     * Número do CNPJ
     */
    public string $CNPJ;

    /**
     * Número do CPF
     */
    public string $CPF;

    /**
     * Número da inscrição municipal
     */
    public ?string $IM = null;

    /**
     * Data da Inscrição Municipal: Dia, mês e ano (AAAAMMDD)
     */
    public string $dInscricaoMunicipal;

    /**
     * Grupo de informações do endereço do contribuinte do CNC
     */
    public \NFSe\Dto\V1_0_1\CEnderContribuinteCNCData $enderContribuinteCNC;

    /**
     * Número do telefone do prestador:
     * Preencher com o Código DDD + número do telefone.
     * Nas operações com exterior é permitido informar o código do país + código da
     * localidade + número do telefone)
     */
    public ?string $fone = null;

    /**
     * Endereço de e-mail para contato com o contribuinte
     */
    public ?string $email = null;

    /**
     * Tipos de Regimes Especiais de Tributação:
     * 0 - Nenhum;
     * 1 - Ato Cooperado (Cooperativa);
     * 2 - Estimativa;
     * 3 - Microempresa Municipal;
     * 4 - Notário ou Registrador;
     * 5 - Profissional Autônomo;
     * 6 - Sociedade de Profissionais;
     */
    public string $regEspTribContribuinteCNC;

    /**
     * Identificação da situação do cadastro do contribuinte
     */
    public ?string $situacaoCadastroContribuinte = null;

    /**
     * Motivo pelo qual o contribuinte se enquadra na situação informada
     */
    public ?string $motivoSituacaoCadastroContribuinte = null;

    /**
     * Situação Emissão NFS-e:
     * 0 - Não Habilitado;
     * 1 - Habilitado;
     */
    public string $situacaoEmissaoNFSE;

}
