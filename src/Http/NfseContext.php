<?php

namespace Nfse\Http;

use Nfse\Enums\TipoAmbiente;

class NfseContext
{
    public function __construct(
        public TipoAmbiente $ambiente,
        public string $certificatePath,
        public string $certificatePassword
    ) {}
}
