<?php

namespace Nfse\Service;

use Nfse\Enums\TipoNsu;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Client\CncClient;
use Nfse\Http\NfseContext;

class MunicipioService
{
    private AdnClient $adnClient;

    private CncClient $cncClient;

    public function __construct(NfseContext $context)
    {
        $this->adnClient = new AdnClient($context);
        $this->cncClient = new CncClient($context);
    }

    /**
     * ADN Município - Baixa arrecadação e notas do município via NSU
     */
    public function baixarDfe(int $nsu, ?TipoNsu $tipoNSU = null, bool $lote = true): \Nfse\Http\Dto\DistribuicaoDfeResponse
    {
        return $this->adnClient->baixarDfeMunicipio($nsu, $tipoNSU, $lote);
    }

    public function downloadDanfse(string $chaveAcesso): string
    {
        return $this->adnClient->obterDanfse($chaveAcesso);
    }

    /**
     * ADN Recepção - Envio de lote de documentos XML (DPS, Eventos)
     */
    public function enviarLote(string $xmlZipB64): array
    {
        return $this->adnClient->enviarLote($xmlZipB64);
    }

    /**
     * ADN Parâmetros Municipais
     */
    public function consultarParametrosConvenio(string $codigoMunicipio): \Nfse\Http\Dto\ResultadoConsultaConfiguracoesConvenioResponse
    {
        return $this->adnClient->consultarParametrosConvenio($codigoMunicipio);
    }

    public function consultarAliquota(string $codigoMunicipio, string $codigoServico, string $competencia): \Nfse\Http\Dto\ResultadoConsultaAliquotasResponse
    {
        return $this->adnClient->consultarAliquota($codigoMunicipio, $codigoServico, $competencia);
    }

    public function consultarHistoricoAliquotas(string $codigoMunicipio, string $codigoServico): \Nfse\Http\Dto\ResultadoConsultaAliquotasResponse
    {
        return $this->adnClient->consultarHistoricoAliquotas($codigoMunicipio, $codigoServico);
    }

    public function consultarBeneficio(string $codigoMunicipio, string $numeroBeneficio, string $competencia): array
    {
        return $this->adnClient->consultarBeneficio($codigoMunicipio, $numeroBeneficio, $competencia);
    }

    public function consultarRegimesEspeciais(string $codigoMunicipio, string $codigoServico, string $competencia): array
    {
        return $this->adnClient->consultarRegimesEspeciais($codigoMunicipio, $codigoServico, $competencia);
    }

    public function consultarRetencoes(string $codigoMunicipio, string $competencia): array
    {
        return $this->adnClient->consultarRetencoes($codigoMunicipio, $competencia);
    }

    /**
     * CNC Consulta - Consulta dados atuais de um contribuinte
     */
    public function consultarContribuinte(string $cpfCnpj): array
    {
        return $this->cncClient->consultarContribuinte($cpfCnpj);
    }

    /**
     * CNC Município - Baixa alterações no cadastro nacional via NSU
     */
    public function baixarAlteracoesCadastro(int $nsu): array
    {
        return $this->cncClient->baixarAlteracoesCadastro($nsu);
    }

    /**
     * CNC Recepção - Cadastra ou atualiza um contribuinte no CNC
     */
    public function atualizarContribuinte(array $dados): array
    {
        return $this->cncClient->atualizarContribuinte($dados);
    }
}
