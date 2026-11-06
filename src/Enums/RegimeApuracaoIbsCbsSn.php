<?php

namespace Nfse\Enums;

/**
 * Regime de apuração do IBS e da CBS para optantes do Simples Nacional.
 *
 * Baseado na NT 009/2026, campo regApIBSCBSSN.
 */
enum RegimeApuracaoIbsCbsSn: string
{
    /**
     * IBS e CBS apurados pelo Simples Nacional.
     */
    case SimplesNacional = '1';

    /**
     * CBS apurada pelo Simples Nacional e IBS pelo regime regular.
     */
    case CbsSimplesIbsRegular = '2';

    /**
     * IBS e CBS apurados pelo regime regular.
     */
    case RegimeRegular = '3';

    public function getDescription(): string
    {
        return match ($this) {
            self::SimplesNacional => 'IBS e CBS apurados pelo Simples Nacional',
            self::CbsSimplesIbsRegular => 'CBS apurada pelo Simples Nacional e IBS pelo regime regular',
            self::RegimeRegular => 'IBS e CBS apurados pelo regime regular',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
