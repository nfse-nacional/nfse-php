<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCListaDocData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCListaDoc
 */
class CRTCListaDocData 
{
    /**
     * Grupo de informações de documentos fiscais eletrônicos que se encontram no repositório nacional
     */
    public \NFSe\Dto\V1_0_1\CRTCListaDocDFeData $dFeNacional;

    /**
     * Grupo de informações de documento fiscais, eletrônicos ou não, que não se encontram no
     * repositório nacional
     */
    public \NFSe\Dto\V1_0_1\CRTCListaDocFiscalOutroData $docFiscalOutro;

    /**
     * Grupo de informações de documento não fiscal.
     */
    public \NFSe\Dto\V1_0_1\CRTCListaDocOutroData $docOutro;

    /**
     * Grupo de informações do fornecedor do documento referenciado
     */
    public ?\NFSe\Dto\V1_0_1\CRTCListaDocFornecData $fornec = null;

    /**
     * Data da emissão do documento dedutível
     * Ano, mês e dia (AAAA-MM-DD)
     */
    public string $dtEmiDoc;

    /**
     * Data da competência do documento dedutível
     * Ano, mês e dia (AAAA-MM-DD)
     */
    public string $dtCompDoc;

    /**
     * Tipo de valor incluído neste documento, recebido por motivo de estarem relacionadas a operações
     * de terceiros,
     * objeto de reembolso, repasse ou ressarcimento pelo recebedor, já tributados e aqui
     * referenciados
     */
    public string $tpReeRepRes;

    /**
     * Descrição do reembolso ou ressarcimento quando a opção é
     * "99 – Outros reembolsos ou ressarcimentos recebidos por valores pagos relativos a
     * operações por conta e ordem de terceiro"
     */
    public ?string $xTpReeRepRes = null;

    /**
     * Valor monetário (total ou parcial, conforme documento informado) utilizado para não inclusão na
     * base de cálculo
     * do ISS e do IBS e da CBS da NFS-e que está sendo emitida (R$)
     */
    public string $vlrReeRepRes;

}
