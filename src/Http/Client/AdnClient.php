<?php

namespace Nfse\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Nfse\Dto\Http\AliquotaDto;
use Nfse\Dto\Http\DistribuicaoDfeResponse;
use Nfse\Dto\Http\DistribuicaoNsuDto;
use Nfse\Dto\Http\MensagemProcessamentoDto;
use Nfse\Dto\Http\ParametrosConfiguracaoConvenioDto;
use Nfse\Dto\Http\ResultadoConsultaAliquotasResponse;
use Nfse\Dto\Http\ResultadoConsultaConfiguracoesConvenioResponse;
use Nfse\Enums\TipoAmbiente;
use Nfse\Enums\TipoNsu;
use Nfse\Http\Contracts\AdnDanfseInterface;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;

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
                throw NfseApiException::responseError('Resposta inválida (não é JSON): '.$content);
            }

            return $decoded;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->handleException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * ADN Contribuinte
     */
    public function baixarDfeContribuinte(int $nsu, ?string $cnpjConsulta = null, bool $lote = true): DistribuicaoDfeResponse
    {
        $queryParams = [];
        if ($cnpjConsulta) {
            $queryParams['cnpjConsulta'] = $cnpjConsulta;
        }
        if (! $lote) {
            $queryParams['lote'] = 'false';
        }

        $url = "/contribuintes/DFe/{$nsu}";
        if (! empty($queryParams)) {
            $url .= '?'.http_build_query($queryParams);
        }

        $response = $this->get($url);

        return $this->mapDistribuicaoResponse($response);
    }

    public function consultarEventosContribuinte(string $chaveAcesso): array
    {
        return $this->get("/contribuintes/NFSe/{$chaveAcesso}/Eventos");
    }

    /**
     * ADN Município
     */
    public function baixarDfeMunicipio(int $nsu, ?TipoNsu $tipoNSU = null, bool $lote = true): DistribuicaoDfeResponse
    {
        $queryParams = [];
        if ($tipoNSU) {
            $queryParams['tipoNSU'] = $tipoNSU->value;
        }
        if (! $lote) {
            $queryParams['lote'] = 'false';
        }

        $url = "/municipios/DFe/{$nsu}";
        if (! empty($queryParams)) {
            $url .= '?'.http_build_query($queryParams);
        }

        $response = $this->get($url);

        return $this->mapDistribuicaoResponse($response);
    }

    /**
     * ADN Recepção
     */
    public function enviarLote(string $xmlZipB64): array
    {
        try {
            $response = $this->httpClient->post('/adn/DFe', [
                RequestOptions::JSON => [
                    'LoteXmlGZipB64' => [$xmlZipB64],
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->handleException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * ADN Parâmetros Municipais
     */
    public function consultarParametrosConvenio(string $codigoMunicipio): ResultadoConsultaConfiguracoesConvenioResponse
    {
        $response = $this->get("/parametrizacao/{$codigoMunicipio}/convenio");

        return new ResultadoConsultaConfiguracoesConvenioResponse([
            'mensagem' => $response['mensagem'] ?? null,
            'parametrosConvenio' => isset($response['parametrosConvenio'])
                ? new ParametrosConfiguracaoConvenioDto($response['parametrosConvenio'])
                : null,
        ]);
    }

    public function consultarAliquota(string $codigoMunicipio, string $codigoServico, string $competencia): ResultadoConsultaAliquotasResponse
    {
        $servicoEncoded = rawurlencode($codigoServico);
        $competenciaEncoded = rawurlencode($competencia);

        $response = $this->get("/parametrizacao/{$codigoMunicipio}/{$servicoEncoded}/{$competenciaEncoded}/aliquota");

        return $this->mapAliquotaResponse($response);
    }

    public function consultarHistoricoAliquotas(string $codigoMunicipio, string $codigoServico): ResultadoConsultaAliquotasResponse
    {
        $response = $this->get("/parametrizacao/{$codigoMunicipio}/{$codigoServico}/historicoaliquotas");

        return $this->mapAliquotaResponse($response);
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
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->handleException($e);
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    private function mapDistribuicaoResponse(array $response): DistribuicaoDfeResponse
    {
        $listaNsu = array_map(fn ($item) => new DistribuicaoNsuDto([
            'NSU' => $item['NSU'] ?? null,
            'chAcesso' => $item['ChaveAcesso'] ?? null,
            'dfeXmlGZipB64' => $item['ArquivoXml'] ?? null,
        ]), $response['LoteDFe'] ?? []);

        $ultimoNsu = $response['UltimoNSU'] ?? null;
        $maiorNsu = $response['MaiorNSU'] ?? null;

        if (empty($ultimoNsu) && ! empty($listaNsu)) {
            $nsus = array_map(fn ($item) => $item->nsu, $listaNsu);
            $maxNsu = max($nsus);
            $ultimoNsu = $maxNsu;
            $maiorNsu = $maxNsu;
        }

        return new DistribuicaoDfeResponse([
            'tpAmb' => $response['TipoAmbiente'] ?? null,
            'verAplic' => $response['VersaoAplicativo'] ?? null,
            'dhProc' => $response['DataHoraProcessamento'] ?? null,
            'ultNSU' => $ultimoNsu,
            'maiorNSU' => $maiorNsu,
            'alertas' => $this->mapMensagens($response['Alertas'] ?? []),
            'erros' => $this->mapMensagens($response['Erros'] ?? []),
            'lNSU' => $listaNsu,
        ]);
    }

    private function mapAliquotaResponse(array $response): ResultadoConsultaAliquotasResponse
    {
        $aliquotas = [];
        foreach ($response['aliquotas'] ?? [] as $servico => $lista) {
            $aliquotas[$servico] = array_map(fn ($item) => new AliquotaDto($item), $lista);
        }

        return new ResultadoConsultaAliquotasResponse([
            'mensagem' => $response['mensagem'] ?? null,
            'aliquotas' => $aliquotas,
        ]);
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
     * @param  \GuzzleHttp\Exception\RequestException|\Exception  $e
     * @return mixed
     * @throws NfseApiException
     */
    private function handleException(\GuzzleHttp\Exception\RequestException|\Exception $e)
    {
        $responseBody = '';
        if ($e->hasResponse()) {
            $responseBody = $e->getResponse()->getBody()->getContents();
        }

        $parsedErrors = [];
        if ($responseBody) {
            $decoded = json_decode($responseBody, true);
            if (is_array($decoded) && isset($decoded['erros']) && is_array($decoded['erros'])) {
                $parsedErrors = $this->mapMensagens($decoded['erros']);
            }
        }

        $message = $responseBody ? "Erro na requisição: {$responseBody}" : $e->getMessage();
        throw NfseApiException::requestError($message, $e->getCode(), $responseBody ?: null, $parsedErrors);
    }
}
