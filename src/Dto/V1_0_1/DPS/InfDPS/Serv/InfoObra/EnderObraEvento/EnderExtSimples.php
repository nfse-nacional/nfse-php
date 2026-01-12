<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\Serv\InfoObra\EnderObraEvento;

use NFSe\Dto\Attributes\MapFrom;

/**
 * EnderExtSimples
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCEnderExtSimples
 */
class EnderExtSimples 
{
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
