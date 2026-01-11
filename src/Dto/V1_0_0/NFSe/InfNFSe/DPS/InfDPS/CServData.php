<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS;

/**
 * CServData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCServ
 */
class CServData 
{
    /**
     * Grupo de informações relativas ao local da prestação do serviço
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Serv\CLocPrestData $locPrest;

    /**
     * Grupo de informações relativas ao código do serviço prestado
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Serv\CCServData $cServ;

    /**
     * Grupo de informações relativas à exportação/importação de serviço prestado
     */
    public ?\NFSe\Dto\V1_0_0\CComExteriorData $comExt = null;

    /**
     * Grupo de informações relativas a atividades de Locação, sublocação, arrendamento, direito de
     * passagem ou permissão de uso, compartilhado ou não, de ferrovia, rodovia, postes, cabos, dutos e
     * condutos de qualquer natureza
     */
    public ?\NFSe\Dto\V1_0_0\CLocacaoSublocacaoData $lsadppu = null;

    /**
     * Grupo de informações do DPS relativas à serviço de obra
     */
    public ?\NFSe\Dto\V1_0_0\CInfoObraData $obra = null;

    /**
     * Grupo de informações do DPS relativas à Evento
     */
    public ?\NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Serv\CAtvEventoData $atvEvento = null;

    /**
     * Grupo de informações relativas a pedágio
     */
    public ?\NFSe\Dto\V1_0_0\CExploracaoRodoviariaData $explRod = null;

    /**
     * Grupo de informações complementares disponível para todos os serviços prestados
     */
    public ?\NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Serv\CInfoComplData $infoCompl = null;

}
