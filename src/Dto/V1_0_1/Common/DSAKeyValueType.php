<?php

namespace NFSe\Dto\V1_0_1\Common;

use NFSe\Dto\Attributes\MapFrom;

/**
 * DSAKeyValueType
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: DSAKeyValueType
 */
class DSAKeyValueType 
{
    public string $P;

    public string $Q;

    public ?string $G = null;

    public string $Y;

    public ?string $J = null;

    public string $Seed;

    public string $PgenCounter;

}
