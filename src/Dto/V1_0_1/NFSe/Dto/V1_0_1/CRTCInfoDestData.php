<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCInfoDestData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCInfoDest
 */
class CRTCInfoDestData 
{
    /**
     * Número da inscrição no Cadastro Nacional de Pessoa Jurídica (CNPJ) do Destinatário do serviço
     */
    public string $CNPJ;

    /**
     * Número da inscrição no Cadastro de Pessoa Física (CPF) do Destinatário do serviço
     */
    public string $CPF;

    /**
     * Número de Identificação Fiscal fornecido por órgão de administração tributária no exterior
     */
    public string $NIF;

    /**
     * Motivo para não informação do NIF:
     * 0 - Não informado na nota de origem;
     * 1 - Dispensado do NIF;
     * 2 - Não exigência do NIF;
     */
    public string $cNaoNIF;

    /**
     * Nome / Nome Empresarial do do Destinatário do serviço
     */
    public string $xNome;

    /**
     * Grupo de informações do endereço do Destinatário do serviço
     */
    public ?\NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\CEnderecoData $end = null;

    /**
     * Número do telefone do Destinatário do serviço
     * (Preencher com o Código DDD + número do telefone. Nas operações com exterior é
     * permitido informar o
     * código do país + código da localidade + número do telefone)
     */
    public ?string $fone = null;

    /**
     * E-mail do Destinatário do serviço
     */
    public ?string $email = null;

}
