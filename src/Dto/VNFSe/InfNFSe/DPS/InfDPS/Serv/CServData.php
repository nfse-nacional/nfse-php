<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

class CServData 
{
    /**
     * Verificar se o código de tributação nacional informado existe e está administrado pelo
     * município de incidência do ISSQN na data de competência informada na DPS, conforme a lista de
     * serviços nacional do Sistema Nacional NFS-e.
     */
    public ?string $cTribNac = null;

    /**
     * Verificar se o código de tributação municipal informado existe e está administrado pelo
     * município de incidência do ISSQN na data de competência informada na DPS.
     */
    public ?string $cTribMun = null;

    /**
     * -
     */
    public ?string $xDescServ = null;

    /**
     * O código da lista NBS informado na DPS não existe, conforme tabela NBS do
     * ANEXO_B-NBS2-LISTA_SERVICO_NACIONAL-SNNFSe do Manual Integrado do Sistema Nacional NFS-e.
     */
    public ?string $cNBS = null;

    /**
     * -
     */
    public ?string $cIntContrib = null;

}
