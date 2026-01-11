<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS;

/**
 * CInfoPrestadorData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoPrestador
 */
class CInfoPrestadorData 
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
     * 1 - Dispensado do NIF;
     * 2 - Não exigência do NIF;
     */
    public string $cNaoNIF;

    /**
     * Número do Cadastro de Atividade Econômica da Pessoa Física (CAEPF) do prestador do serviço.
     */
    public ?string $CAEPF = null;

    /**
     * Número da inscrição municipal
     */
    public ?string $IM = null;

    /**
     * Nome/Nome Empresarial do prestador
     */
    public ?string $xNome = null;

    /**
     * Dados de endereço do prestador
     */
    public ?\NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\CEnderecoData $end = null;

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

    /**
     * Grupo de informações relativas aos regimes de tributação do prestador de serviços
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\CRegTribData $regTrib;

}
