<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * Serv
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCServ
 */
class Serv 
{
    /**
     * Grupo de informações relativas ao local da prestação do serviço
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\LocPrest $locPrest;

    /**
     * Grupo de informações relativas ao código do serviço prestado
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\CServ $cServ;

    /**
     * Grupo de informações relativas à exportação/importação de serviço prestado
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\ComExterior $comExt = null;

    /**
     * Grupo de informações relativas a atividades de Locação, sublocação, arrendamento, direito de
     * passagem ou permissão de uso, compartilhado ou não, de ferrovia, rodovia, postes, cabos, dutos e
     * condutos de qualquer natureza
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\LocacaoSublocacao $lsadppu = null;

    /**
     * Grupo de informações do DPS relativas à serviço de obra
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\InfoObra $obra = null;

    /**
     * Grupo de informações do DPS relativas à Evento
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\AtvEvento $atvEvento = null;

    /**
     * Grupo de informações relativas a pedágio
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\ExploracaoRodoviaria $explRod = null;

    /**
     * Grupo de informações complementares disponível para todos os serviços prestados
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\Serv\InfoCompl $infoCompl = null;

}
