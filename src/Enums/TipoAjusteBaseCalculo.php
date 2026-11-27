<?php

namespace Nfse\Enums;

/**
 * Tipo de ajuste da base de cálculo do ISSQN e/ou IBS/CBS.
 *
 * Baseado no schema: TSRTCTpAjusteBC
 */
enum TipoAjusteBaseCalculo: string
{
    /**
     * Materiais
     */
    case Materiais = '2';

    /**
     * Repasse consorciado
     */
    case RepasseConsorciado = '5';

    /**
     * Repasse plano de saúde
     */
    case RepassePlanoSaude = '6';

    /**
     * Serviços
     */
    case Servicos = '7';

    /**
     * Subempreitada de mão de obra
     */
    case SubempreitadaMaoObra = '8';

    /**
     * Profissional parceiro
     */
    case ProfissionalParceiro = '9';

    /**
     * Outras deduções exclusivas do ISSQN
     */
    case OutrasDeducoes = '99';

    /**
     * Repasse de remuneração por intermediação de imóveis
     */
    case RepasseIntermediacaoImoveis = '101';

    /**
     * Repasse de valores a fornecedor por agência de turismo
     */
    case RepasseAgenciaTurismo = '102';

    /**
     * Reembolso de produção externa por agência de propaganda
     */
    case ReembolsoProducaoExterna = '103';

    /**
     * Reembolso de mídia por agência de propaganda
     */
    case ReembolsoMidia = '104';

    /**
     * Glosa de serviços de saúde
     */
    case GlosaServicosSaude = '105';

    /**
     * Outros reembolsos ou ressarcimentos
     */
    case OutrosReembolsos = '199';

    public function getDescription(): string
    {
        return match ($this) {
            self::Materiais => 'Materiais',
            self::RepasseConsorciado => 'Repasse consorciado',
            self::RepassePlanoSaude => 'Repasse plano de saúde',
            self::Servicos => 'Serviços',
            self::SubempreitadaMaoObra => 'Subempreitada de mão de obra',
            self::ProfissionalParceiro => 'Profissional parceiro',
            self::OutrasDeducoes => 'Outras deduções exclusivas do ISSQN',
            self::RepasseIntermediacaoImoveis => 'Repasse de remuneração por intermediação de imóveis a demais corretores',
            self::RepasseAgenciaTurismo => 'Repasse de valores a fornecedor relativo a fornecimento intermediado por agência de turismo',
            self::ReembolsoProducaoExterna => 'Reembolso ou ressarcimento de serviços de produção externa por conta e ordem de terceiro',
            self::ReembolsoMidia => 'Reembolso ou ressarcimento de serviços de mídia por conta e ordem de terceiro',
            self::GlosaServicosSaude => 'Glosa de serviços de saúde',
            self::OutrosReembolsos => 'Outros reembolsos ou ressarcimentos recebidos por valores pagos por conta e ordem de terceiro',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
