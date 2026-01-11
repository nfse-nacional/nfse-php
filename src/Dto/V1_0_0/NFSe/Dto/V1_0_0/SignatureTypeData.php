<?php

namespace NFSe\Dto\V1_0_0;

/**
 * SignatureTypeData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: SignatureType
 */
class SignatureTypeData 
{
    public \NFSe\Dto\V1_0_0\SignedInfoTypeData $SignedInfo;

    public \NFSe\Dto\V1_0_0\SignatureValueTypeData $SignatureValue;

    public \NFSe\Dto\V1_0_0\KeyInfoTypeData $KeyInfo;

    /**
     * Atributo XML
     */
    public ?string $Id = null;

}
