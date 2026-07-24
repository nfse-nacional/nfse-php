<?php

namespace Nfse\Enums;

/**
 * Tipo de ente governamental, para administração pública direta e suas autarquias e fundações
 */
enum TipoEnteGovernamental: int
{
    /**
     * União
     */
    case Uniao = 1;

    /**
     * Estado
     */
    case Estado = 2;

    /**
     * Distrito Federal
     */
    case DistritoFederal = 3;

    /**
     * Município
     */
    case Municipio = 4;

    public function getDescription(): string
    {
        return match ($this) {
            self::Uniao => 'União',
            self::Estado => 'Estado',
            self::DistritoFederal => 'Distrito Federal',
            self::Municipio => 'Município',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
