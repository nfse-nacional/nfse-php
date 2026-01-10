<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS;

class ServData 
{
    /**
     * -
     */
    public ?string $infoComplem = null;

    /**
     * -
     */
    public ?string $idDocTec = null;

    /**
     * Quando o emitente da DPS for o tomador ou o intermediário do serviço (tpEmit = 2 ou 3,
     * respectivamente) este campo deve ser obrigatoriamente informado.
     */
    public ?string $docRef = null;

    /**
     * -
     */
    public ?string $xInfComp = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\LocPrestData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\LocPrestData $locPrest = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\CServData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\CServData $cServ = null;

    /**
     * EXPORTAÇÃO DE SERVIÇO
     * 
     * Se o emitente for o prestador (tpEmit = 1), e qualquer um dos campos abaixo for informado na DPS
     * 
     * País no exterior do endereço do tomador do serviço,
     * País no exterior do endereço do intermediário do serviço ou
     * cPaisPrestacao é informado ou
     * tribISSQN for Exportação de serviço (tribISSQN = 3),
     * 
     * então o grupo de informações de comércio exterior devem ser informado.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\ComExtData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\ComExtData $comExt = null;

    /**
     * Se o código de tributação nacional pertencer a um dos subitens, 07.02.01, 07.02.02, 07.04.01,
     * 07.05,01, 07.05.02, 07.06.01, 07.06.02, 07.07.01, 07.08.01, 07.17.01 e 07.19.01 da lista de
     * serviços, então o grupo de informações de obra é obrigatório.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\ObraData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\ObraData $obra = null;

    /**
     * Se o código de tributação nacional pertencer ao item 12 da lista de serviços, então o grupo de
     * informações de Atividade/Evento é obrigatório.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEventoData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEventoData $atvEvento = null;

}
