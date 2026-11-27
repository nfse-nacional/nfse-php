<?php

namespace Nfse\Enums;

/**
 * Tipo da cobrança das taxas e demais valores condominiais.
 *
 * Baseado no schema: TSRTCTpCobranca
 */
enum TipoCobrancaCondominio: string
{
    /**
     * Condomínio ordinário
     */
    case CondominioOrdinario = '01';

    /**
     * Condomínio privativo
     */
    case CondominioPrivativo = '02';

    /**
     * Fundo de promoção e propaganda
     */
    case FundoPromocaoPropaganda = '03';

    /**
     * Impostos e taxas
     */
    case ImpostosTaxas = '04';

    /**
     * Fundo de reserva
     */
    case FundoReserva = '05';

    /**
     * Outra cobrança
     */
    case OutraCobranca = '99';

    public function getDescription(): string
    {
        return match ($this) {
            self::CondominioOrdinario => 'Condomínio Ordinário',
            self::CondominioPrivativo => 'Condomínio Privativo',
            self::FundoPromocaoPropaganda => 'Fundo De Promoção E Propaganda (FPP)',
            self::ImpostosTaxas => 'Impostos e Taxas',
            self::FundoReserva => 'Fundo de Reserva',
            self::OutraCobranca => 'Outra Cobrança',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
