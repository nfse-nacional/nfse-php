<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;

/**
 * Resposta da consulta de evento por tipo e sequência.
 *
 * O Sefin devolve um envelope com a lista `eventos`, e não o XML do evento
 * fora dela — por isso o DTO expõe a lista, não um único XML.
 */
class ConsultaEventoResponse extends Dto
{
    public ?int $tipoAmbiente = null;

    public ?string $versaoAplicativo = null;

    public ?string $dataHoraProcessamento = null;

    /** @var EventoDto[] */
    public array $eventos = [];

    /**
     * Primeiro evento da lista, se a consulta retornou algum.
     *
     * A consulta é por tipo + sequência, então na prática a lista tem 0 ou 1
     * item; o primeiro atalho evita indexação manual no chamador.
     */
    public function primeiroEvento(): ?EventoDto
    {
        return $this->eventos[0] ?? null;
    }
}
