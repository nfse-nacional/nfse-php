<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCInfoIBSCBSData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCInfoIBSCBS
 */
class CRTCInfoIBSCBSData 
{
    /**
     * Indicador da finalidade da emissão de NFS-e
     */
    public string $finNFSe;

    /**
     * Indica operação de uso ou consumo pessoal (art. 57)
     */
    public ?string $indFinal = null;

    /**
     * Código indicador da operação de fornecimento, conforme tabela "código indicador de operação"
     */
    public string $cIndOp;

    /**
     * Tipo de Operação com Entes Governamentais ou outros serviços sobre bens imóveis
     */
    public ?string $tpOper = null;

    /**
     * Grupo de NFS-e referenciadas
     */
    public ?\NFSe\Dto\V1_0_1\NFSe\CInfoRefNFSeData $gRefNFSe = null;

    /**
     * Tipo de ente governamental
     */
    public ?string $tpEnteGov = null;

    /**
     * A respeito do Destinatário dos serviços
     */
    public string $indDest;

    /**
     * Grupo de informações relativas ao Destinatário
     */
    public ?\NFSe\Dto\V1_0_1\CRTCInfoDestData $dest = null;

    /**
     * Grupo de informações de operações relacionadas a bens imóveis, exceto obras
     */
    public ?\NFSe\Dto\V1_0_1\CRTCInfoImovelData $imovel = null;

    /**
     * Grupo de informações relativas aos valores do serviço prestado para IBS e CBS
     */
    public \NFSe\Dto\V1_0_1\CRTCInfoValoresIBSCBSData $valores;

}
