<?php

namespace Nfse\Enums;

/**
 * Tipo de dedução/redução
 *
 * Baseado no schema: TSIdeDedRed
 */
enum TipoDeducaoReducao: string
{
    /**
     * Alimentação e bebidas/frigobar
     */
    case AlimentacaoBebidas = '1';

    /**
     * Materiais
     */
    case Materiais = '2';

    /**
     * Produção Externa
     */
    case ProducaoExterna = '3';

    /**
     * Reembolso de despesas
     */
    case ReembolsoDespesas = '4';

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
     * Outras deduções
     */
    case OutrasDeducoes = '99';

    /**
     * Get description for the enum case
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::AlimentacaoBebidas => 'Alimentação e bebidas/frigobar',
            self::Materiais => 'Materiais',
            self::ProducaoExterna => 'Produção Externa',
            self::ReembolsoDespesas => 'Reembolso de despesas',
            self::RepasseConsorciado => 'Repasse consorciado',
            self::RepassePlanoSaude => 'Repasse plano de saúde',
            self::Servicos => 'Serviços',
            self::SubempreitadaMaoObra => 'Subempreitada de mão de obra',
            self::ProfissionalParceiro => 'Profissional parceiro',
            self::OutrasDeducoes => 'Outras deduções',
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
