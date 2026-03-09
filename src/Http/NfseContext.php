<?php

namespace Nfse\Http;

use Nfse\Enums\TipoAmbiente;

final class NfseContext
{
    public function __construct(
        public TipoAmbiente $ambiente,
        public string $certificatePath,
        public string $certificatePassword,
        public ?string $codigoMunicipio = null,
    ) {}
}