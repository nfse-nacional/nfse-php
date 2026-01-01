<?php

namespace Nfse\Http\Contracts;

use Nfse\Http\Dto\EmissaoNfseResponse;
use Nfse\Http\Dto\ConsultaNfseResponse;
use Nfse\Http\Dto\ConsultaDpsResponse;
use Nfse\Http\Dto\RegistroEventoResponse;

interface SefinNacionalInterface
{
    public function emitirNfse(string $dpsXmlGZipB64): EmissaoNfseResponse;

    public function consultarNfse(string $chaveAcesso): ConsultaNfseResponse;

    public function consultarDps(string $idDps): ConsultaDpsResponse;

    public function registrarEvento(string $chaveAcesso, string $eventoXmlGZipB64): RegistroEventoResponse;

    public function consultarEvento(string $chaveAcesso, int $tipoEvento, int $numSeqEvento): RegistroEventoResponse;

    public function verificarDps(string $idDps): bool;

    public function listarEventos(string $chaveAcesso): array;

    public function listarEventosPorTipo(string $chaveAcesso, int $tipoEvento): array;
}
