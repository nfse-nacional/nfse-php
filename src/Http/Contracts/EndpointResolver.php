<?php

namespace Nfse\Http\Contracts;

use Nfse\Http\NfseContext;

interface EndpointResolver
{
    public function resolve(NfseContext $context): string;
}
