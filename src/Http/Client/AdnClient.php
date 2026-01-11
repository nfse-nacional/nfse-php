<?php

namespace Nfse\Http\Client;

use Nfse\Http\Dto\AliquotaDto;
use Nfse\Http\Dto\DistribuicaoDfeResponse;
use Nfse\Http\Dto\DistribuicaoNsuDto;
use Nfse\Http\Dto\MensagemProcessamentoDto;
use Nfse\Http\Dto\ParametrosConfiguracaoConvenioDto;
use Nfse\Http\Dto\ResultadoConsultaAliquotasResponse;
use Nfse\Http\Dto\ResultadoConsultaConfiguracoesConvenioResponse;
use Nfse\Enums\TipoNsu;
use Nfse\Http\Contracts\AdnDanfseInterface;

class AdnClient extends AbstractNfseClient implements AdnDanfseInterface
{
    protected function getProductionUrl(): string
    {
        return 'https://adn.nfse.gov.br';
    }

    protected function getHomologationUrl(): string
    {
        return 'https://adn.producaorestrita.nfse.gov.br';
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
        if (!$lote) {
            $queryParams['lote'] = 'false';
        }

        $url = "/contribuintes/DFe/{$nsu}";
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
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
        if (!$lote) {
            $queryParams['lote'] = 'false';
        }

        $url = "/municipios/DFe/{$nsu}";
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        $response = $this->get($url);

        return $this->mapDistribuicaoResponse($response);
    }

    /**
     * ADN Recepção
     */
    public function enviarLote(string $xmlZipB64): array
    {
        return $this->post('/adn/DFe', [
            'LoteXmlGZipB64' => [$xmlZipB64],
        ]);
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
        return $this->getRaw("/danfse/{$chaveAcesso}");
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

        if (empty($ultimoNsu) && !empty($listaNsu)) {
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
            'mensagem' => $m['Mensagem'] ?? null,
            'parametros' => $m['Parametros'] ?? null,
            'codigo' => $m['Codigo'] ?? null,
            'descricao' => $m['Descricao'] ?? null,
            'complemento' => $m['Complemento'] ?? null,
        ]), $mensagens);
    }
}
