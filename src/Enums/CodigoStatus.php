<?php

namespace Nfse\Enums;

/**
 * Código de Status da NFS-e
 *
 * Baseado no schema: cStat
 */
enum CodigoStatus: int
{
    /**
     * NFS-e Gerada
     */
    case NfseGerada = 100;

    /**
     * NFS-e de Substituição Gerada
     */
    case NfseSubstituicaoGerada = 101;

    /**
     * NFS-e de Decisão Judicial
     */
    case NfseDecisaoJudicial = 102;

    /**
     * NFS-e Avulsa
     */
    case NfseAvulsa = 103;

    /**
     * NFS-e MEI
     */
    case NfseMei = 107;

    /**
     * Get description for the enum case
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::NfseGerada => 'NFS-e Gerada',
            self::NfseSubstituicaoGerada => 'NFS-e de Substituição Gerada',
            self::NfseDecisaoJudicial => 'NFS-e de Decisão Judicial',
            self::NfseAvulsa => 'NFS-e Avulsa',
            self::NfseMei => 'NFS-e MEI',
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
