<?php

namespace Nfse\Enums;

/**
 * Modo de Prestação do Serviço (Comércio Exterior)
 *
 * Baseado no schema: TSModoPrestacao
 */
enum ModoPrestacao: string
{
    /**
     * Desconhecido (tipo não informado na nota de origem)
     */
    case Desconhecido = '0';

    /**
     * Transfronteiriço
     */
    case Transfronteirico = '1';

    /**
     * Consumo no Brasil
     */
    case ConsumoNoBrasil = '2';

    /**
     * Movimento temporário de pessoas físicas
     */
    case MovimentoTemporarioPessoasFisicas = '3';

    /**
     * Consumo no exterior
     */
    case ConsumoNoExterior = '4';

    /**
     * Consumo concomitante no território nacional e no exterior. Schema 20261124.
     */
    case ConsumoConcomitante = '5';

    public function getDescription(): string
    {
        return match ($this) {
            self::Desconhecido => 'Desconhecido (tipo não informado na nota de origem)',
            self::Transfronteirico => 'Transfronteiriço',
            self::ConsumoNoBrasil => 'Consumo no Brasil',
            self::MovimentoTemporarioPessoasFisicas => 'Movimento Temporário de Pessoas Físicas',
            self::ConsumoNoExterior => 'Consumo no Exterior',
            self::ConsumoConcomitante => 'Consumo concomitante no território nacional e no exterior',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
