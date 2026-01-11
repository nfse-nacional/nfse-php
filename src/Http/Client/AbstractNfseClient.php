<?php

namespace Nfse\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;

abstract class AbstractNfseClient
{
    protected Client $httpClient;

    public function __construct(protected NfseContext $context)
    {
        $this->httpClient = $this->createHttpClient();
    }

    /**
     * Retorna a URL base para produção
     */
    abstract protected function getProductionUrl(): string;

    /**
     * Retorna a URL base para homologação
     */
    abstract protected function getHomologationUrl(): string;

    /**
     * Cria o cliente HTTP com configurações padrão
     */
    protected function createHttpClient(): Client
    {
        $baseUrl = $this->context->ambiente === TipoAmbiente::Producao
            ? $this->getProductionUrl()
            : $this->getHomologationUrl();

        return new Client([
            'base_uri' => $baseUrl,
            'curl' => $this->getCurlOptions(),
            RequestOptions::HEADERS => $this->getDefaultHeaders(),
        ]);
    }

    /**
     * Retorna as opções CURL padrão
     */
    protected function getCurlOptions(): array
    {
        return [
            CURLOPT_SSLCERTTYPE => 'P12',
            CURLOPT_SSLCERT => $this->context->certificatePath,
            CURLOPT_SSLCERTPASSWD => $this->context->certificatePassword,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ];
    }

    /**
     * Retorna os headers HTTP padrão
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Executa uma requisição GET e retorna o JSON decodificado
     *
     * @throws NfseApiException
     */
    protected function get(string $endpoint): array
    {
        try {
            $response = $this->httpClient->get($endpoint);
            
            return $this->decodeJsonResponse($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Executa uma requisição POST e retorna o JSON decodificado
     *
     * @throws NfseApiException
     */
    protected function post(string $endpoint, array $data): array
    {
        try {
            $response = $this->httpClient->post($endpoint, [
                RequestOptions::JSON => $data,
            ]);
            
            return $this->decodeJsonResponse($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Executa uma requisição PUT e retorna o JSON decodificado
     *
     * @throws NfseApiException
     */
    protected function put(string $endpoint, array $data): array
    {
        try {
            $response = $this->httpClient->put($endpoint, [
                RequestOptions::JSON => $data,
            ]);
            
            return $this->decodeJsonResponse($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Executa uma requisição DELETE e retorna o JSON decodificado
     *
     * @throws NfseApiException
     */
    protected function delete(string $endpoint): array
    {
        try {
            $response = $this->httpClient->delete($endpoint);
            
            return $this->decodeJsonResponse($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Executa uma requisição GET e retorna o conteúdo bruto (não-JSON)
     *
     * @throws NfseApiException
     */
    protected function getRaw(string $endpoint): string
    {
        try {
            $response = $this->httpClient->get($endpoint);
            
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Decodifica uma resposta JSON
     *
     * @throws NfseApiException
     */
    protected function decodeJsonResponse(string $content): array
    {
        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw NfseApiException::responseError('Resposta inválida (não é JSON): ' . $content);
        }

        return $decoded;
    }

    /**
     * Trata exceções de requisição HTTP
     *
     * @throws NfseApiException
     */
    protected function handleRequestException(RequestException $e): NfseApiException
    {
        $message = $e->getMessage();
        
        if ($e->hasResponse()) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $message = "Erro na requisição: {$responseBody}";
        }
        
        return NfseApiException::requestError($message, $e->getCode());
    }
}
