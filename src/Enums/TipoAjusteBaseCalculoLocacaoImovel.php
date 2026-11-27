<?php

namespace Nfse\Enums;

/**
 * Tipo de parcela que não entra na base de cálculo do IBS e da CBS da locação.
 *
 * Baseado no schema: TSAjusteBCLocImoveis
 */
enum TipoAjusteBaseCalculoLocacaoImovel: string
{
    /**
     * Tributos inclusos no aluguel
     */
    case Tributos = '01';

    /**
     * Emolumento incluso no aluguel
     */
    case Emolumento = '02';

    /**
     * Condomínio incluso no aluguel
     */
    case Condominio = '03';

    /**
     * Redutor social
     */
    case RedutorSocial = '04';

    /**
     * Outras parcelas
     */
    case OutrasParcelas = '99';

    public function getDescription(): string
    {
        return match ($this) {
            self::Tributos => 'Tributos inclusos no aluguel ou equivalente',
            self::Emolumento => 'Emolumento incluso no aluguel ou equivalente',
            self::Condominio => 'Condomínio incluso no aluguel ou equivalente',
            self::RedutorSocial => 'Redutor social',
            self::OutrasParcelas => 'Outras parcelas inclusas no aluguel ou equivalente',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
