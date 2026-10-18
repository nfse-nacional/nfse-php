<?php

namespace Nfse\Http;

use Nfse\Enums\TipoAmbiente;

final class NfseContext
{
    public function __construct(
        public TipoAmbiente $ambiente,
        public ?string $certificatePath = null,
        public string $certificatePassword = '',
        public ?string $codigoMunicipio = null,
        public ?\Nfse\Dto\Http\Endpoint $endpoint = null,
        public ?string $certificateContent = null,
        public ?string $nssCertificateSelector = null,
    ) {
        if ($certificatePath === null && $certificateContent === null && $nssCertificateSelector === null) {
            throw new \InvalidArgumentException('Informe certificado PFX ou seletor de certificado NSS.');
        }

        if ($nssCertificateSelector !== null && trim($nssCertificateSelector) === '') {
            throw new \InvalidArgumentException('O seletor do certificado NSS não pode ser vazio.');
        }
    }
}
