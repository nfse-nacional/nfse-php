<?php

namespace Nfse\Enums;

/**
 * Código indicador da operação de fornecimento (cIndOp).
 *
 * Baseado no schema: TSRTCCodIndOp e na aba CÓDIGO_INDICADOR_OPERAÇÃO do Anexo I (20/10/2026).
 */
enum CodigoIndicadorOperacao: string
{
    /**
     * Bem Móvel Material
     */
    case Ind010101 = '010101';

    /**
     * Bem Móvel Material
     */
    case Ind010102 = '010102';

    /**
     * Bem Móvel Material
     */
    case Ind010103 = '010103';

    /**
     * Bem Móvel Material
     */
    case Ind010106 = '010106';

    /**
     * Operação com bem imóvel, bem imaterial, inclusive direito, relacionada a bem imóvel
     */
    case Ind020101 = '020101';

    /**
     * Serviço prestado fisicamente sobre bem imóvel
     */
    case Ind020201 = '020201';

    /**
     * Serviço prestado fisicamente sobre bem imóvel
     */
    case Ind020202 = '020202';

    /**
     * Serviço de administração e intermediação de bem imóvel
     */
    case Ind020301 = '020301';

    /**
     * Serviços de locação, sublocação, arrendamento, direito de passagem ou permissão de uso, compartilhado ou não, de ferrovia, rodovia, postes, cabos, dutos e condutos de qualquer natureza
     */
    case Ind020401 = '020401';

    /**
     * Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física
     */
    case Ind030101 = '030101';

    /**
     * Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física
     */
    case Ind030102 = '030102';

    /**
     * Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física
     */
    case Ind030103 = '030103';

    /**
     * Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física
     */
    case Ind030104 = '030104';

    /**
     * Serviço de planejamento, organização e administração de feiras, exposições, congressos, espetáculos, exibições e congêneres
     */
    case Ind040101 = '040101';

    /**
     * Serviço prestado fisicamente sobre bem móvel material
     */
    case Ind050101 = '050101';

    /**
     * Serviço prestado fisicamente sobre bem móvel material
     */
    case Ind050102 = '050102';

    /**
     * Serviço prestado fisicamente sobre bem móvel material
     */
    case Ind050103 = '050103';

    /**
     * Serviço prestado fisicamente sobre bem móvel material
     */
    case Ind050104 = '050104';

    /**
     * Serviços portuários
     */
    case Ind050201 = '050201';

    /**
     * Serviço de transporte de passageiros
     */
    case Ind060101 = '060101';

    /**
     * Serviço de transporte de carga
     */
    case Ind070101 = '070101';

    /**
     * Serviço de transporte de carga
     */
    case Ind070102 = '070102';

    /**
     * Execução de serviços de exploração de via
     */
    case Ind080101 = '080101';

    /**
     * Cessão de espaço para prestação de serviços publicitários, em operações onerosas
     */
    case Ind100101 = '100101';

    /**
     * Cessão de espaço para prestação de serviços publicitários, em operações onerosas
     */
    case Ind100102 = '100102';

    /**
     * Demais serviços, em operações não onerosas
     */
    case Ind100201 = '100201';

    /**
     * Demais bens, em operações onerosas
     */
    case Ind100301 = '100301';

    /**
     * Demais bens, em operações onerosas
     */
    case Ind100302 = '100302';

    /**
     * Demais bens, em operações não onerosas
     */
    case Ind100401 = '100401';

    /**
     * Demais bens, em operações onerosas
     */
    case Ind100501 = '100501';

    /**
     * Demais bens, em operações onerosas
     */
    case Ind100502 = '100502';

    /**
     * Demais bens, em operações não onerosas
     */
    case Ind100601 = '100601';

    public function getDescription(): string
    {
        return match ($this) {
            self::Ind010101 => 'Bem Móvel Material',
            self::Ind010102 => 'Bem Móvel Material',
            self::Ind010103 => 'Bem Móvel Material',
            self::Ind010106 => 'Bem Móvel Material',
            self::Ind020101 => 'Operação com bem imóvel, bem imaterial, inclusive direito, relacionada a bem imóvel',
            self::Ind020201 => 'Serviço prestado fisicamente sobre bem imóvel',
            self::Ind020202 => 'Serviço prestado fisicamente sobre bem imóvel',
            self::Ind020301 => 'Serviço de administração e intermediação de bem imóvel',
            self::Ind020401 => 'Serviços de locação, sublocação, arrendamento, direito de passagem ou permissão de uso, compartilhado ou não, de ferrovia, rodovia, postes, cabos, dutos e condutos de qualquer natureza',
            self::Ind030101 => 'Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física',
            self::Ind030102 => 'Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física',
            self::Ind030103 => 'Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física',
            self::Ind030104 => 'Serviço prestado fisicamente sobre a pessoa ou fruído presencialmente por pessoa física',
            self::Ind040101 => 'Serviço de planejamento, organização e administração de feiras, exposições, congressos, espetáculos, exibições e congêneres',
            self::Ind050101 => 'Serviço prestado fisicamente sobre bem móvel material',
            self::Ind050102 => 'Serviço prestado fisicamente sobre bem móvel material',
            self::Ind050103 => 'Serviço prestado fisicamente sobre bem móvel material',
            self::Ind050104 => 'Serviço prestado fisicamente sobre bem móvel material',
            self::Ind050201 => 'Serviços portuários',
            self::Ind060101 => 'Serviço de transporte de passageiros',
            self::Ind070101 => 'Serviço de transporte de carga',
            self::Ind070102 => 'Serviço de transporte de carga',
            self::Ind080101 => 'Execução de serviços de exploração de via',
            self::Ind100101 => 'Cessão de espaço para prestação de serviços publicitários, em operações onerosas',
            self::Ind100102 => 'Cessão de espaço para prestação de serviços publicitários, em operações onerosas',
            self::Ind100201 => 'Demais serviços, em operações não onerosas',
            self::Ind100301 => 'Demais bens, em operações onerosas',
            self::Ind100302 => 'Demais bens, em operações onerosas',
            self::Ind100401 => 'Demais bens, em operações não onerosas',
            self::Ind100501 => 'Demais bens, em operações onerosas',
            self::Ind100502 => 'Demais bens, em operações onerosas',
            self::Ind100601 => 'Demais bens, em operações não onerosas',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
