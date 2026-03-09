<?php

namespace Nfse\Config;

final class EndpointMap{
    private const DEFAULT = [
        'production' => 'https://sefin.nfse.gov.br/SefinNacional',
        'homologation' => 'https://sefin.producaorestrita.nfse.gov.br/SefinNacional',
    ];

    private const MUNICIPAL = [
        '3511102' => [ // Catanduva/SP
            'production'   => 'https://164.152.60.237/nota/nacional',
            'homologation' => 'https://catanduva.prefeitura.rlz.com.br/nota/nacional',
        ],
    ];

    public static function getProduction(?string $codigoMunicipio = null): string{
        if ($codigoMunicipio && isset(self::MUNICIPAL[$codigoMunicipio]['production'])) {
            return self::MUNICIPAL[$codigoMunicipio]['production'];
        }

        return self::DEFAULT['production'];
    }

    public static function getHomologation(?string $codigoMunicipio = null): string    {
        if ($codigoMunicipio && isset(self::MUNICIPAL[$codigoMunicipio]['homologation'])) {
            return self::MUNICIPAL[$codigoMunicipio]['homologation'];
        }

        return self::DEFAULT['homologation'];
    }
}