<?php

namespace Nfse\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Nfse\Dto\Http\ConsultaDpsResponse;
use Nfse\Dto\Http\ConsultaNfseResponse;
use Nfse\Dto\Http\EmissaoNfseResponse;
use Nfse\Dto\Http\MensagemProcessamentoDto;
use Nfse\Dto\Http\RegistroEventoResponse;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Contracts\SefinNacionalInterface;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;

class SefinClient implements SefinNacionalInterface
{
    private const URL_PRODUCTION = 'https://sefin.nfse.gov.br/SefinNacional';

    private const URL_HOMOLOGATION = 'https://sefin.producaorestrita.nfse.gov.br/SefinNacional';

    private Client $httpClient;

    public function __construct(private NfseContext $context)
    {
        $this->httpClient = $this->createHttpClient();
    }

    private function createHttpClient(): Client
    {
        $baseUrl = $this->context->ambiente === TipoAmbiente::Producao
            ? self::URL_PRODUCTION
            : self::URL_HOMOLOGATION;

        return new Client([
            'base_uri' => rtrim($baseUrl, '/').'/',
            'curl' => [
                CURLOPT_SSLCERTTYPE => 'P12',
                CURLOPT_SSLCERT => $this->context->certificatePath,
                CURLOPT_SSLCERTPASSWD => $this->context->certificatePassword,
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ],
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    private function post(string $endpoint, array $data): array
    {
        try {
            $response = $this->httpClient->post($endpoint, [
                RequestOptions::JSON => $data,
            ]);

            $body = $response->getBody()->getContents();
            $decoded = json_decode($body, true);

            if (! is_array($decoded)) {
                throw NfseApiException::responseError('Resposta inválida da API: não foi possível decodificar JSON.');
            }

            return $decoded;
        } catch (GuzzleException $e) {
            $this->handleException($e);
        }
    }

    private function get(string $endpoint): array
    {
        try {
            $response = $this->httpClient->get($endpoint);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $this->handleException($e);
        }
    }

    public function emitirNfse(string $dpsXmlGZipB64): EmissaoNfseResponse
    {
        $response = $this->post('nfse', ['dpsXmlGZipB64' => $dpsXmlGZipB64]);

        return new EmissaoNfseResponse(
            tipoAmbiente: $response['tipoAmbiente'] ?? null,
            versaoAplicativo: $response['versaoAplicativo'] ?? null,
            dataHoraProcessamento: $response['dataHoraProcessamento'] ?? null,
            idDps: $response['idDps'] ?? null,
            chaveAcesso: $response['chaveAcesso'] ?? null,
            nfseXmlGZipB64: $response['nfseXmlGZipB64'] ?? null,
            alertas: $this->mapMensagens($response['alertas'] ?? []),
            erros: $this->mapMensagens($response['erros'] ?? [])
        );
    }

    public function consultarNfse(string $chaveAcesso): ConsultaNfseResponse
    {
        $response = $this->get("nfse/{$chaveAcesso}");

        return new ConsultaNfseResponse(
            tipoAmbiente: $response['tipoAmbiente'] ?? null,
            versaoAplicativo: $response['versaoAplicativo'] ?? null,
            dataHoraProcessamento: $response['dataHoraProcessamento'] ?? null,
            chaveAcesso: $response['chaveAcesso'] ?? null,
            nfseXmlGZipB64: $response['nfseXmlGZipB64'] ?? null
        );
    }

    public function consultarDps(string $idDps): ConsultaDpsResponse
    {
        $response = $this->get("dps/{$idDps}");

        return new ConsultaDpsResponse(
            tipoAmbiente: $response['tipoAmbiente'] ?? null,
            versaoAplicativo: $response['versaoAplicativo'] ?? null,
            dataHoraProcessamento: $response['dataHoraProcessamento'] ?? null,
            idDps: $response['idDps'] ?? null,
            chaveAcesso: $response['chaveAcesso'] ?? null
        );
    }

    public function registrarEvento(string $chaveAcesso, string $eventoXmlGZipB64): RegistroEventoResponse
    {
        $response = $this->post("nfse/{$chaveAcesso}/eventos", [
            'pedidoRegistroEventoXmlGZipB64' => $eventoXmlGZipB64,
        ]);

        return new RegistroEventoResponse(
            tipoAmbiente: $response['tipoAmbiente'] ?? null,
            versaoAplicativo: $response['versaoAplicativo'] ?? null,
            dataHoraProcessamento: $response['dataHoraProcessamento'] ?? null,
            eventoXmlGZipB64: $response['eventoXmlGZipB64'] ?? null
        );
    }

    public function consultarEvento(string $chaveAcesso, int $tipoEvento, int $numSeqEvento): RegistroEventoResponse
    {
        $response = $this->get("nfse/{$chaveAcesso}/eventos/{$tipoEvento}/{$numSeqEvento}");

        return new RegistroEventoResponse(
            tipoAmbiente: $response['tipoAmbiente'] ?? null,
            versaoAplicativo: $response['versaoAplicativo'] ?? null,
            dataHoraProcessamento: $response['dataHoraProcessamento'] ?? null,
            eventoXmlGZipB64: $response['eventoXmlGZipB64'] ?? null
        );
    }

    public function verificarDps(string $idDps): bool
    {
        try {
            $this->httpClient->head("dps/{$idDps}");

            return true;
        } catch (GuzzleException $e) {
            if ($e->getCode() === 404) {
                return false;
            }
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    public function listarEventos(string $chaveAcesso): array
    {
        return $this->get("nfse/{$chaveAcesso}/eventos");
    }

    public function listarEventosPorTipo(string $chaveAcesso, int $tipoEvento): array
    {
        return $this->get("nfse/{$chaveAcesso}/eventos/{$tipoEvento}");
    }

    private function mapMensagens(array $mensagens): array
    {
        return array_map(fn ($m) => new MensagemProcessamentoDto(
            mensagem: $m['mensagem'] ?? $m['Mensagem'] ?? null,
            parametros: $m['parametros'] ?? $m['Parametros'] ?? null,
            codigo: $m['codigo'] ?? $m['Codigo'] ?? null,
            descricao: $m['descricao'] ?? $m['Descricao'] ?? null,
            complemento: $m['complemento'] ?? $m['Complemento'] ?? null
        ), $mensagens);
    }

    /**
     * @param  \Exception|GuzzleException  $e
     * @return mixed
     * @throws NfseApiException
     */
    private function handleException(\Exception|GuzzleException $e)
    {
        $errorBody = '';
        if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->getResponse()) {
            $errorBody = $e->getResponse()->getBody()->getContents();
        }

        $parsedErrors = [];
        if ($errorBody) {
            $decoded = json_decode($errorBody, true);
            if (is_array($decoded) && isset($decoded['erros']) && is_array($decoded['erros'])) {
                $parsedErrors = $this->mapMensagens($decoded['erros']);
            }
        }

        throw NfseApiException::requestError(
            $e->getMessage().($errorBody ? "\nResposta: ".$errorBody : ''),
            $e->getCode(),
            $errorBody ?: null,
            $parsedErrors
        );
    }
}
