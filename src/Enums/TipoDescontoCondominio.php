<?php

namespace Nfse\Enums;

/**
 * Tipo do desconto aplicado pelo condomínio.
 *
 * Baseado no schema: TSRTCTpDesconto
 */
enum TipoDescontoCondominio: string
{
    /**
     * Desconto incondicionado
     */
    case DescontoIncondicionado = '1';

    /**
     * Desconto condicionado
     */
    case DescontoCondicionado = '2';

    public function getDescription(): string
    {
        return match ($this) {
            self::DescontoIncondicionado => 'Desconto Incondicionado',
            self::DescontoCondicionado => 'Desconto Condicionado',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
