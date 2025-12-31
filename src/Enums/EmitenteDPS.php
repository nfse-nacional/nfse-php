<?php

namespace Nfse\Enums;

/**
 * Emitente da DPS
 * 
 * Baseado no schema: TSEmitenteDPS
 */
enum EmitenteDPS: string
{
    /**
     * Prestador
     */
    case Prestador = '1';

    /**
     * Tomador
     */
    case Tomador = '2';

    /**
     * Intermediário
     */
    case Intermediario = '3';

    /**
     * Get description for the enum case
     * 
     * @return string
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::Prestador => 'Prestador',
            self::Tomador => 'Tomador',
            self::Intermediario => 'Intermediário',
        };
    }

    /**
     * Get label (alias for getDescription)
     * 
     * @return string
     */
    public function label(): string
    {
        return $this->getDescription();
    }
}
