<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCListaDocFiscalOutroData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCListaDocFiscalOutro
 */
class CRTCListaDocFiscalOutroData 
{
    /**
     * Código do município emissor do documento fiscal que não se encontra no repositório nacional
     */
    public string $cMunDocFiscal;

    /**
     * Número do documento fiscal que não se encontra no repositório nacional
     */
    public string $nDocFiscal;

    /**
     * Descrição do documento fiscal
     */
    public string $xDocFiscal;

}
