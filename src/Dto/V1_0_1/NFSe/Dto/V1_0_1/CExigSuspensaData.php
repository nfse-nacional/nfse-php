<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CExigSuspensaData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCExigSuspensa
 */
class CExigSuspensaData 
{
    /**
     * Opção para Exigibilidade Suspensa:
     * 1 - Exigibilidade Suspensa por Decisão Judicial;
     * 2 - Exigibilidade Suspensa por Processo Administrativo;
     */
    public string $tpSusp;

    /**
     * Número do processo judicial ou administrativo de suspensão da exigibilidade
     */
    public string $nProcesso;

}
