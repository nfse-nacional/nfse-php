<?php

namespace NFSe\Dto\V1_0_0\Common;

use NFSe\Dto\Attributes\MapFrom;

/**
 * SignatureType
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: SignatureType
 */
class SignatureType 
{
    public \NFSe\Dto\V1_0_0\Common\SignedInfoType $SignedInfo;

    public \NFSe\Dto\V1_0_0\Common\SignatureValueType $SignatureValue;

    public \NFSe\Dto\V1_0_0\Common\KeyInfoType $KeyInfo;

    /**
     * Atributo XML
     */
    public ?string $Id = null;

}
