<?php

namespace NFSe\Dto\V1_0_1\Common;

use NFSe\Dto\Attributes\MapFrom;

/**
 * X509DataType
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: X509DataType
 */
class X509DataType 
{
    public \NFSe\Dto\V1_0_1\Common\X509IssuerSerialType $X509IssuerSerial;

    public string $X509SKI;

    public string $X509SubjectName;

    public string $X509Certificate;

    public string $X509CRL;

}
