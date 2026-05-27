<?php

namespace Nfse\Service;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\NfseData;
use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\Contracts\SefinNacionalInterface;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;
use Nfse\Signer\Certificate;
use Nfse\Signer\SignerInterface;
use Nfse\Signer\XmlSigner;
use Nfse\Xml\DpsXmlBuilder;
use Nfse\Xml\EventosXmlBuilder;
use Nfse\Xml\NfseXmlParser;

class ContribuinteService
{
    private SefinNacionalInterface $sefinClient;

    private AdnClient $adnClient;

    public function __construct(private NfseContext $context)
    {
        $this->sefinClient = new SefinClient($context);
        $this->adnClient = new AdnClient($context);
    }

    /**
     * Emite uma NFS-e a partir de um DPS.
     */
    public function emitir(DpsData $dps): NfseData
    {
        $builder = new DpsXmlBuilder;
        $xml = $builder->build($dps);

        $cert = $this->makeCertificate();
        $signer = $this->createSigner($cert);

        // Assina a tag 'infDPS'
        $signedXml = $signer->sign($xml, 'infDPS');

        // Envelope (GZIP + Base64)
        $payload = base64_encode(gzencode($signedXml));

        // Transport
        $response = $this->sefinClient->emitirNfse($payload);

        if (! empty($response->erros)) {
            $msg = 'Erro na emissão: ' . json_encode($response->erros);
            throw NfseApiException::responseError($msg, 0, null, $response->erros);
        }

        if (! $response->nfseXmlGZipB64) {
            throw NfseApiException::responseError('Resposta sem XML da NFS-e.');
        }

        $nfseXml = gzdecode(base64_decode($response->nfseXmlGZipB64));

        $parser = new NfseXmlParser;

        return $parser->parse($nfseXml);
    }

    public function consultar(string $chave): ?NfseData
    {
        try {
            $response = $this->sefinClient->consultarNfse($chave);
        } catch (NfseApiException $e) {
            return null;
        }

        if (! $response->nfseXmlGZipB64) {
            return null;
        }

        $nfseXml = gzdecode(base64_decode($response->nfseXmlGZipB64));

        $parser = new NfseXmlParser;

        return $parser->parse($nfseXml);
    }

    public function consultarDps(string $idDps): \Nfse\Dto\Http\ConsultaDpsResponse
    {
        return $this->sefinClient->consultarDps($idDps);
    }

    /**
     * Baixa o DANFSe gerado pela API oficial do ambiente nacional.
     *
     * @deprecated A API oficial do ambiente nacional para geração do Documento Auxiliar
     * da Nota Fiscal de Serviços Eletrônica (DANFSe) será descontinuada em 1º de julho de 2026. A emissão
     * passará a ser responsabilidade dos sistemas emissores, ERPs e softwares das próprias empresas.
     * Fim da API de Geração: a interface oficial do governo que gerava o DANFSe será desligada.
     * Responsabilidade do Emissor: ERPs, softwares de gestão e plataformas de contabilidade precisarão
     * gerar o DANFSe internamente e adequar seus layouts. Novo Layout: o documento agora possui um formato
     * padrão obrigatório em folha A4, exigência de QR Code e inclusão de campos para IBS e CBS.
     * Nota técnica: https://www.gov.br/nfse/pt-br/biblioteca/documentacao-tecnica/rtc/nt-008-se-cgnfse-danfse-20260505.pdf
     */
    public function downloadDanfse(string $chaveAcesso): string
    {
        return $this->adnClient->obterDanfse($chaveAcesso);
    }

    public function verificarDps(string $idDps): bool
    {
        return $this->sefinClient->verificarDps($idDps);
    }

    public function registrarEvento(string $chaveAcesso, string $eventoXmlGZipB64): \Nfse\Dto\Http\RegistroEventoResponse
    {
        return $this->sefinClient->registrarEvento($chaveAcesso, $eventoXmlGZipB64);
    }

    /**
     * Registra um evento a partir de um DTO.
     */
    public function registrarEventoData(PedRegEventoData $evento): \Nfse\Dto\Http\RegistroEventoResponse
    {
        $builder = new EventosXmlBuilder;
        $xml = $builder->buildPedRegEvento($evento);

        $cert = $this->makeCertificate();
        $signer = $this->createSigner($cert);

        // Assina a tag 'infPedReg'
        $signedXml = $signer->sign($xml, 'infPedReg');

        // Envelope (GZIP + Base64)
        $payload = base64_encode(gzencode($signedXml));

        return $this->registrarEvento($evento->infPedReg->chaveNfse, $payload);
    }

    /**
     * Atalho para cancelamento de NFS-e (Evento 101101).
     */
    public function cancelar(PedRegEventoData $evento): \Nfse\Dto\Http\RegistroEventoResponse
    {
        // Garante o código do evento de cancelamento
        $evento->infPedReg->tipoEvento = '101101';

        return $this->registrarEventoData($evento);
    }

    public function consultarEvento(string $chaveAcesso, int $tipoEvento, int $numSeqEvento): \Nfse\Dto\Http\RegistroEventoResponse
    {
        return $this->sefinClient->consultarEvento($chaveAcesso, $tipoEvento, $numSeqEvento);
    }

    public function listarEventos(string $chaveAcesso, ?int $tipoEvento = null): array
    {
        if ($tipoEvento) {
            return $this->sefinClient->listarEventosPorTipo($chaveAcesso, $tipoEvento);
        }

        return $this->sefinClient->listarEventos($chaveAcesso);
    }

    /**
     * ADN Contribuinte - Baixa documentos via NSU
     */
    public function baixarDfe(int $nsu, ?string $cnpjConsulta = null, bool $lote = true): \Nfse\Dto\Http\DistribuicaoDfeResponse
    {
        return $this->adnClient->baixarDfeContribuinte($nsu, $cnpjConsulta, $lote);
    }

    /**
     * ADN Contribuinte - Consulta eventos de uma nota
     */
    public function consultarEventos(string $chaveAcesso): array
    {
        return $this->adnClient->consultarEventosContribuinte($chaveAcesso);
    }

    public function consultarParametrosConvenio(string $codigoMunicipio): \Nfse\Dto\Http\ResultadoConsultaConfiguracoesConvenioResponse
    {
        return $this->adnClient->consultarParametrosConvenio($codigoMunicipio);
    }

    public function consultarAliquota(string $codigoMunicipio, string $codigoServico, string $competencia): \Nfse\Dto\Http\ResultadoConsultaAliquotasResponse
    {
        return $this->adnClient->consultarAliquota($codigoMunicipio, $codigoServico, $competencia);
    }

    public function consultarHistoricoAliquotas(string $codigoMunicipio, string $codigoServico): \Nfse\Dto\Http\ResultadoConsultaAliquotasResponse
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

    protected function createSigner(Certificate $certificate): SignerInterface
    {
        return new XmlSigner($certificate);
    }

    private function makeCertificate(): Certificate
    {
        if ($this->context->certificateContent !== null) {
            return Certificate::fromContent($this->context->certificateContent, $this->context->certificatePassword);
        }

        return new Certificate($this->context->certificatePath, $this->context->certificatePassword);
    }
}
