<?php

namespace Nfse\Http;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Handler do Guzzle que repete a requisição nas instabilidades do ambiente
 * nacional (502/503/504 e queda de conexão), com o backoff exponencial padrão
 * do Guzzle (1s, 2s).
 *
 * Só repete métodos idempotentes: reenviar um POST duplicaria NFS-e ou evento.
 */
class Retry
{
    private const MAX_RETRIES = 2;

    private const RETRY_STATUS = [502, 503, 504];

    public static function stack(?callable $handler = null): HandlerStack
    {
        $stack = HandlerStack::create($handler);

        $stack->push(Middleware::retry(static function (
            int $retries,
            RequestInterface $request,
            ?ResponseInterface $response = null,
            ?\Throwable $exception = null
        ): bool {
            if ($retries >= self::MAX_RETRIES || ! in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
                return false;
            }

            return $exception instanceof ConnectException
                || in_array($response?->getStatusCode(), self::RETRY_STATUS, true);
        }));

        return $stack;
    }
}
