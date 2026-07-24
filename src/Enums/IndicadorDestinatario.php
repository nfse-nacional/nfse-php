<?php

namespace Nfse\Enums;

/**
 * Indicador a respeito do destinatário dos serviços
 */
enum IndicadorDestinatario: int
{
    /**
     * O destinatário é o próprio tomador/adquirente identificado na NFS-e
     * (tomador = adquirente = destinatário)
     */
    case DestinatarioTomador = 0;

    /**
     * O destinatário não é o próprio adquirente, podendo ser outra pessoa, física ou
     * jurídica (ou equiparada), ou um estabelecimento diferente do indicado como tomador
     * (tomador = adquirente ≠ destinatário)
     */
    case DestinatarioDiverso = 1;

    public function getDescription(): string
    {
        return match ($this) {
            self::DestinatarioTomador => 'O destinatário é o próprio tomador/adquirente',
            self::DestinatarioDiverso => 'O destinatário não é o próprio adquirente',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
