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
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * ADN Contribuinte
     */
    public function baixarDfeContribuinte(int $nsu): DistribuicaoDfeResponse
    {
        $response = $this->get("/contribuintes/dfe/{$nsu}");

        return $this->mapDistribuicaoResponse($response);
    }

    public function consultarEventosContribuinte(string $chaveAcesso): array
    {
        return $this->get("/contribuintes/nfse/{$chaveAcesso}/eventos");
    }

    /**
     * ADN Município
     */
    public function baixarDfeMunicipio(int $nsu): DistribuicaoDfeResponse
    {
        $response = $this->get("/municipios/dfe/{$nsu}");

        return $this->mapDistribuicaoResponse($response);
    }

    /**
     * ADN Recepção
     */
    public function enviarLote(string $xmlZipB64): array
    {
        try {
            $response = $this->httpClient->post('/dfe', [
                RequestOptions::JSON => [
                    'arquivo' => $xmlZipB64,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
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

        return new ResultadoConsultaConfiguracoesConvenioResponse(
            mensagem: $response['mensagem'] ?? null,
            parametrosConvenio: isset($response['parametrosConvenio'])
                ? new ParametrosConfiguracaoConvenioDto(
                    tipoConvenio: $response['parametrosConvenio']['tipoConvenio'] ?? null,
                    aderenteAmbienteNacional: $response['parametrosConvenio']['aderenteAmbienteNacional'] ?? null,
                    aderenteEmissorNacional: $response['parametrosConvenio']['aderenteEmissorNacional'] ?? null,
                    situacaoEmissaoPadraoContribuintesRFB: $response['parametrosConvenio']['situacaoEmissaoPadraoContribuintesRFB'] ?? null,
                    aderenteMAN: $response['parametrosConvenio']['aderenteMAN'] ?? null,
                    permiteAproveitametoDeCreditos: $response['parametrosConvenio']['permiteAproveitametoDeCreditos'] ?? null,
                )
                : null
        );
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
        } catch (GuzzleException $e) {
            throw NfseApiException::requestError($e->getMessage(), $e->getCode());
        }
    }

    private function mapDistribuicaoResponse(array $response): DistribuicaoDfeResponse
    {
        return new DistribuicaoDfeResponse(
            tipoAmbiente: $response['tipoAmbiente'] ?? null,
            versaoAplicativo: $response['versaoAplicativo'] ?? null,
            dataHoraProcessamento: $response['dataHoraProcessamento'] ?? null,
            ultimoNsu: $response['ultimoNSU'] ?? null,
            maiorNsu: $response['maiorNSU'] ?? null,
            alertas: $this->mapMensagens($response['alertas'] ?? []),
            erros: $this->mapMensagens($response['erros'] ?? []),
            listaNsu: array_map(fn ($item) => new DistribuicaoNsuDto(
                nsu: $item['nsu'] ?? null,
                dfeXmlGZipB64: $item['xmlGZipB64'] ?? null
            ), $response['listaNSU'] ?? [])
        );
    }

    private function mapAliquotaResponse(array $response): ResultadoConsultaAliquotasResponse
    {
        $aliquotas = [];
        foreach ($response['aliquotas'] ?? [] as $servico => $lista) {
            $aliquotas[$servico] = array_map(fn ($item) => new AliquotaDto(
                incidencia: $item['Incidencia'] ?? null,
                aliquota: $item['Aliq'] ?? null,
                dataInicio: $item['DtIni'] ?? null,
                dataFim: $item['DtFim'] ?? null
            ), $lista);
        }

        return new ResultadoConsultaAliquotasResponse(
            mensagem: $response['mensagem'] ?? null,
            aliquotas: $aliquotas
        );
    }

    private function mapMensagens(array $mensagens): array
    {
        return array_map(fn ($m) => new MensagemProcessamentoDto(
            mensagem: $m['mensagem'] ?? null,
            parametros: $m['parametros'] ?? null,
            codigo: $m['codigo'] ?? null,
            descricao: $m['descricao'] ?? null,
            complemento: $m['complemento'] ?? null
        ), $mensagens);
    }
}
