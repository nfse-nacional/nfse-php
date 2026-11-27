<?php

namespace Nfse\Enums;

/**
 * Vínculo da Operação à Movimentação Temporária de Bens
 *
 * Baseado no schema: TSMovTempBens
 */
enum MovimentacaoTemporariaBens: string
{
    /**
     * Desconhecido (tipo não informado na nota de origem)
     */
    case Desconhecido = '0';

    /**
     * Não
     */
    case Nao = '1';

    /**
     * Vinculada à Declaração de Importação
     */
    case DeclaracaoImportacao = '2';

    /**
     * Vinculada à Declaração de Exportação
     */
    case DeclaracaoExportacao = '3';

    /**
     * Get description for the enum case
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::Desconhecido => 'Desconhecido (tipo não informado na nota de origem)',
            self::Nao => 'Não',
            self::DeclaracaoImportacao => 'Vinculada - Declaração de Importação',
            self::DeclaracaoExportacao => 'Vinculada - Declaração de Exportação',
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
