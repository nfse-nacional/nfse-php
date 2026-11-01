<?php

namespace Nfse\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Nfse\Dto\Http\MensagemProcessamentoDto;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;
use Nfse\Http\Retry;

class CncClient
{
    private const URL_PRODUCTION = 'https://adn.nfse.gov.br/cnc';

    private const URL_HOMOLOGATION = 'https://adn.producaorestrita.nfse.gov.br/cnc';

    private Client $httpClient;

    private ?string $tempCertFile = null;

    public function __construct(private NfseContext $context)
    {
        $this->httpClient = $this->createHttpClient();
    }

    public function __destruct()
    {
        if ($this->tempCertFile !== null && file_exists($this->tempCertFile)) {
            unlink($this->tempCertFile);
        }
    }

    private function resolveCertificatePath(): string
    {
        if ($this->context->certificatePath !== null) {
            return $this->context->certificatePath;
        }

        $this->tempCertFile = tempnam(sys_get_temp_dir(), 'nfse_cert_');
        file_put_contents($this->tempCertFile, $this->context->certificateContent);

        return $this->tempCertFile;
    }

    private function createHttpClient(): Client
    {
        $baseUrl = $this->context->ambiente === TipoAmbiente::Producao
            ? self::URL_PRODUCTION
            : self::URL_HOMOLOGATION;

        $curlOptions = [];

        if ($this->context->nssCertificateSelector !== null) {
            // O Guzzle exige que a opção `cert` seja um arquivo existente; o seletor NSS não é, então segue cru para o cURL.
            $curlOptions[CURLOPT_SSLCERTTYPE] = 'ENG';
            $curlOptions[CURLOPT_SSLCERT] = $this->context->nssCertificateSelector;
            $certificateOptions = [];
        } else {
            $certificateOptions = [
                RequestOptions::CERT => [$this->resolveCertificatePath(), $this->context->certificatePassword],
                RequestOptions::CERT_TYPE => 'P12',
            ];
        }

        return new Client([
            'base_uri' => $baseUrl,
            'handler' => Retry::stack(),
            ...$certificateOptions,
            'curl' => $curlOptions,
            RequestOptions::FORCE_IP_RESOLVE => 'v4',
            // Com o Retry (3 tentativas), um host inacessível segura a requisição
            // por até 3x o connect timeout; 10s basta para o handshake.
            RequestOptions::CONNECT_TIMEOUT => 10,
            RequestOptions::TIMEOUT => 60,
            RequestOptions::VERSION => '1.1',
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
                throw NfseApiException::responseError('Resposta inválida (não é JSON): '.$content);
            }

            return $decoded;
        } catch (GuzzleException $e) {
            $this->handleException($e);
        }
    }

    private function post(string $endpoint, array $data): array
    {
        try {
            $response = $this->httpClient->post($endpoint, [
                RequestOptions::JSON => $data,
            ]);
            $content = $response->getBody()->getContents();
            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw NfseApiException::responseError('Resposta inválida (não é JSON): '.$content);
            }

            return $decoded;
        } catch (GuzzleException $e) {
            $this->handleException($e);
        }
    }

    /**
     * CNC Consulta - Consulta dados atuais de um contribuinte
     */
    public function consultarContribuinte(string $cpfCnpj): array
    {
        return $this->get("/consulta/cad/{$cpfCnpj}");
    }

    /**
     * CNC Município - Baixa alterações no cadastro nacional via NSU
     */
    public function baixarAlteracoesCadastro(int $nsu): array
    {
        return $this->get("/municipio/cad/{$nsu}");
    }

    /**
     * CNC Recepção - Cadastra ou atualiza um contribuinte no CNC
     */
    public function atualizarContribuinte(array $dados): array
    {
        return $this->post('', $dados);
    }

    private function mapMensagens(array $mensagens): array
    {
        return array_map(fn ($m) => new MensagemProcessamentoDto([
            'mensagem' => $m['Mensagem'] ?? $m['mensagem'] ?? null,
            'parametros' => $m['Parametros'] ?? $m['parametros'] ?? null,
            'codigo' => $m['Codigo'] ?? $m['codigo'] ?? null,
            'descricao' => $m['Descricao'] ?? $m['descricao'] ?? null,
            'complemento' => $m['Complemento'] ?? $m['complemento'] ?? null,
        ]), $mensagens);
    }

    /**
     * @param  array  $decoded
     * @return mixed
     *
     * @throws NfseApiException
     */
    private function handleException(\Exception|GuzzleException $e)
    {
        $errorBody = '';
        if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
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
