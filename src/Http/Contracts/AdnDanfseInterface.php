<?php

namespace Nfse\Http\Contracts;

interface AdnDanfseInterface
{
    public function obterDanfse(string $chaveAcesso): string;
}
