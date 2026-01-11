<?php

namespace NFSe\Dto\V1_0_0;

/**
 * SignedInfoTypeData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: SignedInfoType
 */
class SignedInfoTypeData 
{
    public string $CanonicalizationMethod;

    public string $SignatureMethod;

    public \NFSe\Dto\V1_0_0\ReferenceTypeData $Reference;

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
