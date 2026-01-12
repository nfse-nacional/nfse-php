<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\InfoPrestador\Endereco;

use NFSe\Dto\Attributes\MapFrom;

/**
 * EnderExt
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCEnderExt
 */
class EnderExt 
{
    /**
     * Código do país (Tabela de Países ISO)
     */
    public string $cPais;

    /**
     * Código alfanumérico do Endereçamento Postal no exterior do prestador do serviço.
     */
    public string $cEndPost;

    /**
     * Nome da cidade no exterior do prestador do serviço.
     */
    public string $xCidade;

    /**
     * Estado, província ou região da cidade no exterior do prestador do serviço.
     */
    public string $xEstProvReg;

}
