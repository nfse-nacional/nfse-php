<?php

namespace Nfse\Support;

use Nfse\Config\EndpointMap;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\NfseContext;

final class EndpointResolver
{
    public static function resolve(NfseContext $context): string
    {
        return match ($context->ambiente) {
            TipoAmbiente::Producao => EndpointMap::getProduction($context->codigoMunicipio),
            TipoAmbiente::Homologacao => EndpointMap::getHomologation($context->codigoMunicipio),
        };
    }
}