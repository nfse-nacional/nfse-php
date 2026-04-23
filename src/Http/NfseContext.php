<?php

namespace Nfse\Http;

use Nfse\Enums\TipoAmbiente;

final class NfseContext
{
    public function __construct(
        public TipoAmbiente $ambiente,
        public ?string $certificatePath,
        public string $certificatePassword,
        public ?string $codigoMunicipio = null,
        public ?\Nfse\Dto\Http\Endpoint $endpoint = null,
        public ?string $certificateContent = null,
    ) {
        if ($certificatePath === null && $certificateContent === null) {
            throw new \InvalidArgumentException('Informe certificatePath ou certificateContent.');
        }
    }
}