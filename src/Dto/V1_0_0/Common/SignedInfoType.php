<?php

namespace NFSe\Dto\V1_0_0\Common;

use NFSe\Dto\Attributes\MapFrom;

/**
 * SignedInfoType
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: SignedInfoType
 */
class SignedInfoType 
{
    public string $CanonicalizationMethod;

    public string $SignatureMethod;

    public \NFSe\Dto\V1_0_0\Common\ReferenceType $Reference;

    /**
     * Atributo XML
     */
    public string $Algorithm;

    /**
     * Atributo XML
     */
    public string $Algorithm;

    /**
     * Atributo XML
     */
    public ?string $Id = null;

}
