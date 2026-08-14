<?php

namespace Nfse\Support;

use Nfse\Dto\Http\Endpoint;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Contracts\EndpointResolver;
use Nfse\Http\NfseContext;

class SefinEndpointResolver implements EndpointResolver
{
    private const DEFAULT = [
        'production' => 'https://sefin.nfse.gov.br/SefinNacional',
        'homologation' => 'https://sefin.producaorestrita.nfse.gov.br/SefinNacional',
    ];

    private const ENDPOINTS = [
        '3511102' => [
            'production' => 'https://164.152.60.237/nota/nacional',
            'homologation' => 'https://catanduva.prefeitura.rlz.com.br/nota/nacional',
        ],
    ];

    public function resolve(NfseContext $context): string
    {
        // Padrão
        $endpoint = new Endpoint([
            'production' => self::DEFAULT['production'],
            'homologation' => self::DEFAULT['homologation'],
        ]);

        $codigo = $context->codigoMunicipio;

        if ($codigo && isset(self::ENDPOINTS[$codigo])) {
            $data = self::ENDPOINTS[$codigo];

            $endpoint = new Endpoint([
                'production' => $data['production'],
                'homologation' => $data['homologation'],
            ]);
        }

        // Se o cliente manda um personalizado
        if ($context->endpoint) {
            $endpoint = $context->endpoint;
        }

        return $context->ambiente === TipoAmbiente::Producao
            ? $endpoint->production
            : $endpoint->homologation;
    }

    /**
     * URL do DANFSe no endpoint próprio do município, ou null quando o município
     * não possui endpoint mapeado (nesse caso o download segue pelo ADN nacional).
     */
    public function resolveDanfse(NfseContext $context, string $chaveAcesso): ?string
    {
        if (! $context->codigoMunicipio || ! isset(self::ENDPOINTS[$context->codigoMunicipio])) {
            return null;
        }

        return rtrim($this->resolve($context), '/')."/danfse/{$chaveAcesso}/pdf";
    }
}
