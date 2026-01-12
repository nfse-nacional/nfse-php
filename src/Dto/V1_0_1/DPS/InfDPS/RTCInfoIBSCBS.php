<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCInfoIBSCBS
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCInfoIBSCBS
 */
class RTCInfoIBSCBS 
{
    /**
     * Indicador da finalidade da emissão de NFS-e
     */
    public \Nfse\Enums\V1_0_1\TSRTCFinNFSe $finNFSe;

    /**
     * Indica operação de uso ou consumo pessoal (art. 57)
     */
    public ?\Nfse\Enums\V1_0_1\TSRTCIndFinal $indFinal = null;

    /**
     * Código indicador da operação de fornecimento, conforme tabela "código indicador de operação"
     */
    public string $cIndOp;

    /**
     * Tipo de Operação com Entes Governamentais ou outros serviços sobre bens imóveis
     */
    public ?\Nfse\Enums\V1_0_1\TSRTCTpOper $tpOper = null;

    /**
     * Grupo de NFS-e referenciadas
     */
    public ?\NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\InfoRefNFSe $gRefNFSe = null;

    /**
     * Tipo de ente governamental
     */
    public ?\Nfse\Enums\V1_0_1\TSRTCTpEnteGov $tpEnteGov = null;

    /**
     * A respeito do Destinatário dos serviços
     */
    public \Nfse\Enums\V1_0_1\TSRTCIndDest $indDest;

    /**
     * Grupo de informações relativas ao Destinatário
     */
    public ?\NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\RTCInfoDest $dest = null;

    /**
     * Grupo de informações de operações relacionadas a bens imóveis, exceto obras
     */
    public ?\NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\RTCInfoImovel $imovel = null;

    /**
     * Grupo de informações relativas aos valores do serviço prestado para IBS e CBS
     */
    public \NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\RTCInfoValoresIBSCBS $valores;

}
