<?php

namespace Nfse\Enums;

/**
 * Regime Especial de Tributação
 *
 * Baseado no schema: TSRegEspTrib
 */
enum RegimeEspecialTributacao: string
{
    /**
     * Nenhum
     */
    case Nenhum = '0';

    /**
     * Ato Cooperado (Cooperativa)
     */
    case AtoCooperado = '1';

    /**
     * Estimativa
     */
    case Estimativa = '2';

    /**
     * Microempresa Municipal
     */
    case MicroempresaMunicipal = '3';

    /**
     * Notário ou Registrador
     */
    case NotarioOuRegistrador = '4';

    /**
     * Profissional Autônomo
     */
    case ProfissionalAutonomo = '5';

    /**
     * Sociedade de Profissionais
     */
    case SociedadeDeProfissionais = '6';

    /**
     * Outros
     */
    case Outros = '9';


    /**
     * Get description for the enum case
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::Nenhum => 'Nenhum',
            self::AtoCooperado => 'Ato Cooperado (Cooperativa)',
            self::Estimativa => 'Estimativa',
            self::MicroempresaMunicipal => 'Microempresa Municipal',
            self::NotarioOuRegistrador => 'Notário ou Registrador',
            self::ProfissionalAutonomo => 'Profissional Autônomo',
            self::SociedadeDeProfissionais => 'Sociedade de Profissionais',
            self::Outros => 'Outros',
        };
    }

    /**
     * Get label (alias for getDescription)
     */
    public function label(): string
    {
        return $this->getDescription();
    }
}
