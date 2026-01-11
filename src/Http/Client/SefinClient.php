<?php

namespace Nfse\Http\Client;

use Nfse\Http\Dto\ConsultaDpsResponse;
use Nfse\Http\Dto\ConsultaNfseResponse;
use Nfse\Http\Dto\EmissaoNfseResponse;
use Nfse\Http\Dto\RegistroEventoResponse;
use Nfse\Http\Contracts\SefinNacionalInterface;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;
use GuzzleHttp\Exception\GuzzleException;

class SefinClient extends AbstractNfseClient implements SefinNacionalInterface
{
    private \CuyZ\Valinor\Mapper\TreeMapper $mapper;

    public function __construct(NfseContext $context)
    {
        parent::__construct($context);
        
        $this->mapper = (new \CuyZ\Valinor\MapperBuilder())
            ->allowSuperfluousKeys()
            ->allowScalarValueCasting()
            ->mapper();
    }

    protected function getProductionUrl(): string
    {
        return 'https://sefin.nfse.gov.br/SefinNacional';
    }

    protected function getHomologationUrl(): string
    {
        return 'https://sefin.producaorestrita.nfse.gov.br/SefinNacional';
    }

    public function emitirNfse(string $dpsXmlGZipB64): EmissaoNfseResponse
    {
        $response = $this->post('nfse', ['dpsXmlGZipB64' => $dpsXmlGZipB64]);

        return $this->mapper->map(EmissaoNfseResponse::class, $response);
    }

    public function consultarNfse(string $chaveAcesso): ConsultaNfseResponse
    {
        $response = $this->get("nfse/{$chaveAcesso}");

        return $this->mapper->map(ConsultaNfseResponse::class, $response);
    }

    public function consultarDps(string $idDps): ConsultaDpsResponse
    {
        $response = $this->get("dps/{$idDps}");

        return $this->mapper->map(ConsultaDpsResponse::class, $response);
    }

    public function registrarEvento(string $chaveAcesso, string $eventoXmlGZipB64): RegistroEventoResponse
    {
        $response = $this->post("nfse/{$chaveAcesso}/eventos", [
            'pedidoRegistroEventoXmlGZipB64' => $eventoXmlGZipB64,
        ]);

        return $this->mapper->map(RegistroEventoResponse::class, $response);
    }

    public function consultarEvento(string $chaveAcesso, int $tipoEvento, int $numSeqEvento): RegistroEventoResponse
    {
        $response = $this->get("nfse/{$chaveAcesso}/eventos/{$tipoEvento}/{$numSeqEvento}");

        return $this->mapper->map(RegistroEventoResponse::class, $response);
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
}
