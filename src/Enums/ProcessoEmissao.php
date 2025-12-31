<?php

namespace Nfse\Enums;

/**
 * Processo de Emissão da DPS
 * 
 * Baseado no schema: TSProcEmissao
 */
enum ProcessoEmissao: string
{
    /**
     * Emissão com aplicativo do contribuinte (via Web Service)
     */
    case WebService = '1';

    /**
     * Emissão com aplicativo disponibilizado pelo fisco (Web)
     */
    case WebFisco = '2';

    /**
     * Emissão com aplicativo disponibilizado pelo fisco (App)
     */
    case AppFisco = '3';

    /**
     * Get description for the enum case
     * 
     * @return string
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::WebService => 'Emissão com aplicativo do contribuinte (via Web Service)',
            self::WebFisco => 'Emissão com aplicativo disponibilizado pelo fisco (Web)',
            self::AppFisco => 'Emissão com aplicativo disponibilizado pelo fisco (App)',
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
