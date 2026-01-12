<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * InfoPessoa
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCInfoPessoa
 */
class InfoPessoa 
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
     * Número de Identificação Fiscal fornecido por órgão de administração tributária no exterior
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
     * Número do Cadastro de Atividade Econômica da Pessoa Física (CAEPF) do tomador, intermediário ou
     * fornecedor do serviço.
     */
    public ?string $CAEPF = null;

    /**
     * Número da inscrição municipal
     */
    public ?string $IM = null;

    /**
     * Nome/Nome Empresarial
     */
    public string $xNome;

    /**
     * Dados de endereço
     */
    public ?\NFSe\Dto\V1_0_1\DPS\InfDPS\InfoPrestador\Endereco $end = null;

    /**
     * Número do telefone do prestador:
     * Preencher com o Código DDD + número do telefone.
     * Nas operações com exterior é permitido informar o código do país + código da
     * localidade + número do telefone)
     */
    public ?string $fone = null;

    /**
     * E-mail
     */
    public ?string $email = null;

}
