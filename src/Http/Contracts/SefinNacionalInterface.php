<?php

namespace Nfse\Http\Contracts;

use Nfse\Dto\Http\ConsultaDpsResponse;
use Nfse\Dto\Http\ConsultaEventoResponse;
use Nfse\Dto\Http\ConsultaNfseResponse;
use Nfse\Dto\Http\EmissaoNfseResponse;
use Nfse\Dto\Http\RegistroEventoResponse;

interface SefinNacionalInterface
{
    public function emitirNfse(string $dpsXmlGZipB64): EmissaoNfseResponse;

    public function consultarNfse(string $chaveAcesso): ConsultaNfseResponse;

    public function consultarDps(string $idDps): ConsultaDpsResponse;

    public function registrarEvento(string $chaveAcesso, string $eventoXmlGZipB64): RegistroEventoResponse;

    public function consultarEvento(string $chaveAcesso, int $tipoEvento, int $numSeqEvento): ConsultaEventoResponse;

    public function verificarDps(string $idDps): bool;

    /**
     * @deprecated A API do Sefin Nacional não expõe listagem de eventos.
     */
    public function listarEventos(string $chaveAcesso): array;

    /**
     * @deprecated A API do Sefin Nacional não expõe listagem de eventos.
     */
    public function listarEventosPorTipo(string $chaveAcesso, int $tipoEvento): array;
}
