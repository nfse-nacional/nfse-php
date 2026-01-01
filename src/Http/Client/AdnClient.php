<?php

namespace Nfse\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Nfse\Http\NfseContext;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\Contracts\AdnDanfseInterface;

class AdnClient implements AdnDanfseInterface
{
    private const URL_PRODUCTION = 'https://adn.nfse.gov.br';
    private const URL_HOMOLOGATION = 'https://adn.producaorestrita.nfse.gov.br';

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
            'base_uri' => $baseUrl,
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

    private function get(string $endpoint): array
    {
        try {
            $response = $this->httpClient->get($endpoint);
            $content = $response->getBody()->getContents();
            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw NfseApiException::responseError('Resposta inválida (não é JSON): ' . $content);
            }

            return $decoded;
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * ADN Parâmetros Municipais
     */
    public function consultarParametrosConvenio(string $codigoMunicipio): array
    {
        return $this->get("/parametrizacao/{$codigoMunicipio}/convenio");
    }

    public function consultarAliquota(string $codigoMunicipio, string $codigoServico, string $competencia): array
    {
        $servicoEncoded = rawurlencode($codigoServico);
        $competenciaEncoded = rawurlencode($competencia);
        return $this->get("/parametrizacao/{$codigoMunicipio}/{$servicoEncoded}/{$competenciaEncoded}/aliquota");
    }

    public function consultarHistoricoAliquotas(string $codigoMunicipio, string $codigoServico): array
    {
        return $this->get("/parametrizacao/{$codigoMunicipio}/{$codigoServico}/historicoaliquotas");
    }

    public function consultarBeneficio(string $codigoMunicipio, string $numeroBeneficio, string $competencia): array
    {
        $competenciaEncoded = rawurlencode($competencia);
        return $this->get("/parametrizacao/{$codigoMunicipio}/{$numeroBeneficio}/{$competenciaEncoded}/beneficio");
    }

    public function consultarRegimesEspeciais(string $codigoMunicipio, string $codigoServico, string $competencia): array
    {
        $competenciaEncoded = rawurlencode($competencia);
        return $this->get("/parametrizacao/{$codigoMunicipio}/{$codigoServico}/{$competenciaEncoded}/regimes_especiais");
    }

    public function consultarRetencoes(string $codigoMunicipio, string $competencia): array
    {
        $competenciaEncoded = rawurlencode($competencia);
        return $this->get("/parametrizacao/{$codigoMunicipio}/{$competenciaEncoded}/retencoes");
    }

    /**
     * ADN DANFSe
     */
    public function obterDanfse(string $chaveAcesso): string
    {
        try {
            $response = $this->httpClient->get("/danfse/{$chaveAcesso}");
            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }
}
