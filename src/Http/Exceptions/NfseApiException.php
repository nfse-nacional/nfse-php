<?php

namespace Nfse\Http\Exceptions;

use Exception;
use Nfse\Dto\Http\MensagemProcessamentoDto;

class NfseApiException extends Exception
{
    private ?string $rawResponse = null;

    /** @var MensagemProcessamentoDto[] */
    private array $errors = [];

    public function getRawResponse(): ?string
    {
        return $this->rawResponse;
    }

    /** @return MensagemProcessamentoDto[] */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function requestError(string $message, int $code = 0, ?string $rawResponse = null, array $errors = []): self
    {
        $exception = new self("Erro na requisição: {$message}", $code);
        $exception->rawResponse = $rawResponse;
        $exception->errors = $errors;

        return $exception;
    }

    public static function responseError(string $message, int $code = 0, ?string $rawResponse = null, array $errors = []): self
    {
        $exception = new self("Erro na resposta da API: {$message}", $code);
        $exception->rawResponse = $rawResponse;
        $exception->errors = $errors;

        return $exception;
    }
}
