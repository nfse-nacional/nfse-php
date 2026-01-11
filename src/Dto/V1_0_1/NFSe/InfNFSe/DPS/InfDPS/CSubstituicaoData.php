<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS;

/**
 * CSubstituicaoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCSubstituicao
 */
class CSubstituicaoData 
{
    /**
     * Chave de acesso da NFS-e a ser substituída
     */
    public string $chSubstda;

    /**
     * Código de justificativa para substituição de NFS-e:
     * 01 - Desenquadramento de NFS-e do Simples Nacional;
     * 02 - Enquadramento de NFS-e no Simples Nacional;
     * 03 - Inclusão Retroativa de Imunidade/Isenção para NFS-e;
     * 04 - Exclusão Retroativa de Imunidade/Isenção para NFS-e;
     * 05 - Rejeição de NFS-e pelo tomador ou pelo intermediário se responsável pelo
     * recolhimento do tributo;
     * 99 - Outros;
     */
    public string $cMotivo;

    /**
     * Descrição do motivo da substituição da NFS-e
     */
    public ?string $xMotivo = null;

}
