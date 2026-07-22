<?php

namespace Nfse\Enums;

/**
 * Tipo de valor incluído no documento, recebido por estar relacionado a operações de
 * terceiros, objeto de reembolso, repasse ou ressarcimento pelo recebedor, já tributados
 */
enum TipoReembolsoRepasseRessarcimento: string
{
    /**
     * Repasse de remuneração por intermediação de imóveis a demais corretores envolvidos na operação
     */
    case IntermediacaoImoveis = '01';

    /**
     * Repasse de valores a fornecedor relativo a fornecimento intermediado por agência de turismo
     */
    case AgenciaTurismo = '02';

    /**
     * Reembolso ou ressarcimento recebido por agência de propaganda e publicidade por
     * valores pagos relativos a serviços de produção externa por conta e ordem de terceiro
     */
    case ProducaoExterna = '03';

    /**
     * Reembolso ou ressarcimento recebido por agência de propaganda e publicidade por
     * valores pagos relativos a serviços de mídia por conta e ordem de terceiro
     */
    case Midia = '04';

    /**
     * Outros reembolsos ou ressarcimentos recebidos por valores pagos relativos a
     * operações por conta e ordem de terceiro
     */
    case Outros = '99';

    public function getDescription(): string
    {
        return match ($this) {
            self::IntermediacaoImoveis => 'Repasse de remuneração por intermediação de imóveis a demais corretores envolvidos na operação',
            self::AgenciaTurismo => 'Repasse de valores a fornecedor relativo a fornecimento intermediado por agência de turismo',
            self::ProducaoExterna => 'Reembolso ou ressarcimento por serviços de produção externa por conta e ordem de terceiro',
            self::Midia => 'Reembolso ou ressarcimento por serviços de mídia por conta e ordem de terceiro',
            self::Outros => 'Outros reembolsos ou ressarcimentos por operações por conta e ordem de terceiro',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
