<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\RTCInfoValoresIBSCBS\RTCInfoReeRepRes\RTCListaDoc;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCListaDocFornec
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCListaDocFornec
 */
class RTCListaDocFornec 
{
    /**
     * Número da inscrição no Cadastro Nacional de Pessoa Jurídica (CNPJ) do Fornecedor do serviço
     */
    public string $CNPJ;

    /**
     * Número da inscrição no Cadastro de Pessoa Física (CPF) do Fornecedor do serviço
     */
    public string $CPF;

    /**
     * Este elemento só deverá ser preenchido para fornecedores não residentes no Brasil
     */
    public string $NIF;

    /**
     * Motivo para não informação do NIF:
     * 0 - Não informado na nota de origem;
     * 1 - Dispensado do NIF;
     * 2 - Não exigência do NIF;
     */
    public \Nfse\Enums\V1_0_1\TSCodNaoNIF $cNaoNIF;

    /**
     * Nome / Razão Social do do Fornecedor do serviço
     */
    public string $xNome;

}
