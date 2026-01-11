<?php

namespace NFSe\Dto\V1_0_1;

/**
 * E305103Data
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TE305103
 */
class E305103Data 
{
    /**
     * Descrição do evento: "Desbloqueio de NFS-e por Ofício".
     */
    public string $xDesc;

    /**
     * CPF do agente da administração tributária municipal que efetuou o cancelamento por ofício de
     * NFS-e.
     */
    public string $CPFAgTrib;

    /**
     * Referência ao Id da "Manifestação de rejeição da NFS-e" que originou o presente evento de
     * anulação.
     */
    public string $idBloqOfic;

}
