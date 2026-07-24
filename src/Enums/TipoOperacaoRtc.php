<?php

namespace Nfse\Enums;

/**
 * Tipo de Operação com Entes Governamentais ou outros serviços sobre bens imóveis
 */
enum TipoOperacaoRtc: int
{
    /**
     * Fornecimento com pagamento posterior
     */
    case FornecimentoPagamentoPosterior = 1;

    /**
     * Recebimento do pagamento com fornecimento já realizado
     */
    case RecebimentoFornecimentoRealizado = 2;

    /**
     * Fornecimento com pagamento já realizado
     */
    case FornecimentoPagamentoRealizado = 3;

    /**
     * Recebimento do pagamento com fornecimento posterior
     */
    case RecebimentoFornecimentoPosterior = 4;

    /**
     * Fornecimento e recebimento do pagamento concomitantes
     */
    case FornecimentoRecebimentoConcomitantes = 5;

    public function getDescription(): string
    {
        return match ($this) {
            self::FornecimentoPagamentoPosterior => 'Fornecimento com pagamento posterior',
            self::RecebimentoFornecimentoRealizado => 'Recebimento do pagamento com fornecimento já realizado',
            self::FornecimentoPagamentoRealizado => 'Fornecimento com pagamento já realizado',
            self::RecebimentoFornecimentoPosterior => 'Recebimento do pagamento com fornecimento posterior',
            self::FornecimentoRecebimentoConcomitantes => 'Fornecimento e recebimento do pagamento concomitantes',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }

    /**
     * Indica se o tipo de operação exige o grupo de NFS-e referenciadas.
     */
    public function exigeNfseReferenciada(): bool
    {
        return in_array($this, [self::RecebimentoFornecimentoRealizado, self::FornecimentoPagamentoRealizado], true);
    }
}
