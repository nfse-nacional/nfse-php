<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores;

use NFSe\Dto\Attributes\MapFrom;

/**
 * VServPrest
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCVServPrest
 */
class VServPrest 
{
    /**
     * Valor monetário recebido pelo intermediário do serviço (R$)
     */
    public ?string $vReceb = null;

    /**
     * Valor dos serviços em R$
     */
    public string $vServ;

}
