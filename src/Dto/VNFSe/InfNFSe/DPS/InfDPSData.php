<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS;

class InfDPSData 
{
    /**
     * O identificador da DPS é formado conforme a concatenação dos seguintes campos:
     * "DPS" + Cód.Mun.Emi. + Tipo de Inscrição Federal + Inscrição Federal + Série DPS + Núm. DPS
     * 
     * Campo identificador da DPS inválido.
     * Identificador da DPS difere da concatenação dos campos correspondentes.
     * "DPS" + Cód.Mun.Emi. + Tipo de Inscrição Federal + Inscrição Federal + Série DPS + Núm. DPS
     * 
     * Verificar se tipo de inscrição e inscrição, informados no identificador da DPS, estão
     * corretamente correspondidos conforme o seguinte:
     * 
     * Tipo de inscrição Federal = 1 / Inscrição Federal = CPF emitente da DPS;
     * Tipo de inscrição Federal = 2 / Inscrição Federal = CNPJ emitente da DPS;
     * 
     * Cód.Mun.Emi. é o código do município do endereço do emitente da DPS.
     */
    public ?string $id = null;

    /**
     * Ambiente informado diverge do ambiente de recebimento para o qual o emitente enviou a DPS.
     */
    public ?string $tpAmb = null;

    /**
     * A data de emissão da DPS deve ser anterior ou igual à data e hora do seu processamento (dhProc)
     * pelo Sistema Nacional NFS-e.
     */
    public ?string $dhEmi = null;

    /**
     * -
     */
    public ?string $verAplic = null;

    /**
     * A série informada na DPS não pertence à faixa definida para o tipo de emissor utilizado para a
     * sua emissão.
     */
    public ?string $serie = null;

    /**
     * 
     */
    public ?string $nDPS = null;

    /**
     * A data de competência informada na DPS deve ser anterior ou igual à data de emissão (dhEmi) da
     * DPS.
     */
    public ?string $dCompet = null;

    /**
     * Se a DPS for emitida pelo tomador ou intermendiário (tpEmit = 2 ou 3), então a DPS deve ser
     * rejeitada pelo sistema.
     */
    public ?string $tpEmit = null;

    /**
     * Se o emitente for o prestador de serviço (tpEmit = 1), então este campo não deve ser preenchido.
     */
    public ?string $cMotivoEmisTI = null;

    /**
     * Somente é permitido o preencimento deste campo se o emitente da DPS for o Tomador ou Intermediário
     * (tpEmit igual a 2 ou 3) e o motivo da emissão for a rejeição de NFS-e emitida pelo Prestador
     * (cMotivoEmisTI igual a 4).
     */
    public ?string $chNFSeRej = null;

    /**
     * O código do município emissor informado na DPS deve existir no cadastro de convênio municipal do
     * sistema nacional.
     * Exceto quando o emitente da DPS for MEI na data de competência da emissão da NFS-e.
     */
    public ?string $cLocEmi = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\SubstData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\SubstData $subst = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\PrestData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\PrestData $prest = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\TomaData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\TomaData $toma = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\IntermData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\IntermData $interm = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ServData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ServData $serv = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ValoresData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ValoresData $valores = null;

}
