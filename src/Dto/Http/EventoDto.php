<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;

/**
 * Evento fiscal retornado pela consulta de eventos do Sefin Nacional.
 *
 * O `arquivoXml` é o documento registrado, codificado em base64. Na consulta
 * de evento a API aplica **duas** camadas de base64 sobre o gzip — diferente do
 * `eventoXmlGZipB64` do registro, que traz uma única camada. Use
 * {@see self::arquivoXmlDecodificado()} para obter o XML.
 */
class EventoDto extends Dto
{
    public ?string $chaveAcesso = null;

    public ?int $tipoEvento = null;

    public ?int $numeroPedidoRegistroEvento = null;

    public ?string $dataHoraRecebimento = null;

    public ?string $arquivoXml = null;

    /**
     * Descomprime o XML do evento.
     *
     * Aceita base64 simples ou duplo porque o Sefin não segue a mesma
     * convenção em todos os endpoints de evento.
     */
    public function arquivoXmlDecodificado(): ?string
    {
        if ($this->arquivoXml === null || $this->arquivoXml === '') {
            return null;
        }

        $conteudo = base64_decode($this->arquivoXml, true);

        if ($conteudo === false) {
            return null;
        }

        // O gzip começa com 1f 8b; se ainda for base64, decodifica de novo.
        if (! str_starts_with($conteudo, "\x1f\x8b")) {
            $segundoNivel = base64_decode($conteudo, true);

            if ($segundoNivel !== false) {
                $conteudo = $segundoNivel;
            }
        }

        $xml = @gzdecode($conteudo);

        return $xml === false ? null : $xml;
    }
}
