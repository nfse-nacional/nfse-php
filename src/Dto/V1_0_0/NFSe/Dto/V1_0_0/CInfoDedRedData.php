<?php

namespace NFSe\Dto\V1_0_0;

/**
 * CInfoDedRedData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoDedRed
 */
class CInfoDedRedData 
{
    /**
     * Valor percentual padrão para dedução/redução do valor do serviço
     */
    public string $pDR;

    /**
     * Valor monetário padrão para dedução/redução do valor do serviço
     */
    public string $vDR;

    /**
     * Grupo de informações de documento utilizado para Dedução/Redução do valor do serviço
     */
    public \NFSe\Dto\V1_0_0\CListaDocDedRedData $documentos;

}
