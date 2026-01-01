<?php

namespace Nfse\Http\Exceptions;

use Exception;

class NfseApiException extends Exception
{
    public static function requestError(string $message, int $code = 0): self
    {
        return new self("Erro na requisição: {$message}", $code);
    }

    public static function responseError(string $message, int $code = 0): self
    {
        return new self("Erro na resposta da API: {$message}", $code);
    }
}
