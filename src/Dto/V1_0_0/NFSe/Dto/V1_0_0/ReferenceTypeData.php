<?php

namespace NFSe\Dto\V1_0_0;

/**
 * ReferenceTypeData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: ReferenceType
 */
class ReferenceTypeData 
{
    public \NFSe\Dto\V1_0_0\RansformsTypeData $Transforms;

    public string $DigestMethod;

    public string $DigestValue;

    /**
     * Atributo XML
     */
    public string $Algorithm;

    /**
     * Atributo XML
     */
    public ?string $Id = null;

    /**
     * Atributo XML
     */
    public string $URI;

    /**
     * Atributo XML
     */
    public ?string $Type = null;

}
