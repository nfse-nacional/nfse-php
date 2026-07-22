<?php

namespace Nfse\Enums;

/**
 * Documento fiscal a que se refere a chave de DF-e do Repositório Nacional
 */
enum TipoChaveDFe: int
{
    /**
     * NFS-e
     */
    case Nfse = 1;

    /**
     * NF-e
     */
    case Nfe = 2;

    /**
     * CT-e
     */
    case Cte = 3;

    /**
     * Outro
     */
    case Outro = 9;

    public function getDescription(): string
    {
        return match ($this) {
            self::Nfse => 'NFS-e',
            self::Nfe => 'NF-e',
            self::Cte => 'CT-e',
            self::Outro => 'Outro',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
