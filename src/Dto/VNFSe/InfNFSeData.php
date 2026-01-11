<?php

namespace Nfse\Dto\NFSe;

class InfNFSeData 
{
    /**
     * O identificador da NFS-e é formado conforme a concatenação dos seguintes campos:
     * "NFS" + Cód.Mun. (7) + Amb.Ger. (1) + Tipo de Inscrição Federal (1) + Inscrição Federal (14 -
     * CPF completar com 000 à esquerda) + nNFSe (13) + AnoMes Emis. (4) + Cód.Num. (9) + DV (1)
     * 
     * Verificar se tipo de inscrição e inscrição, informados no identificador da NFS-e, estão
     * corretamente correspondidos conforme o seguinte:
     * 
     * Tipo de inscrição Federal = 1 / Inscrição Federal = CPF emitente da NFS-e;
     * Tipo de inscrição Federal = 2 / Inscrição Federal = CNPJ emitente da NFS-e;
     * 
     * Cód.Mun.Emi. é o código do município do endereço do emitente da NFS-e."
     */
    public ?string $id = null;

    /**
     * -
     */
    public ?string $xLocEmi = null;

    /**
     * -
     */
    public ?string $xLocPrestacao = null;

    /**
     * -
     */
    public ?string $nNFSe = null;

    /**
     * Não é permitido informar o código do local de incidência quando o serviço prestado for imune,
     * exportação de serviço ou não incidência do ISSQN sobre o serviço prestado, ou seja, o campo
     * referente à tributação do ISSQN (tribISSQN) é igual a "2 - Imunidade, "3 - Exportação de
     * Serviço" ou "4 - Não Incidência", (tribISSQN = 2, 3 ou 4).
     */
    public ?string $cLocIncid = null;

    /**
     * -
     */
    public ?string $xLocIncid = null;

    /**
     * -
     */
    public ?string $xTribNac = null;

    /**
     * -
     */
    public ?string $xTribMun = null;

    /**
     * -
     */
    public ?string $xNBS = null;

    /**
     * -
     */
    public ?string $verAplic = null;

    /**
     * Verificar se o ambiente gerador da NFS-e está de acordo com a definição:
     * 1- Sistema Próprio do Município, para as NFS-e compartilhadas pelo município para o ADN, ou
     * 2 - Sefin Nacional NFS-e, para as NFS-e emitidas pela Sefin ou recepcionadas via API "Bypass".
     */
    public ?string $ambGer = null;

    /**
     * -
     */
    public ?string $tpEmis = null;

    /**
     * Os emissores públicos nacionais devem gerar a NFS-e informando qual o processo de emissão:
     * 
     * 1 - Emissão com aplicativo do contribuinte (via Web Service);
     * 2 - Emissão com aplicativo disponibilizado pelo fisco (Web);
     * 3 - Emissão com aplicativo disponibilizado pelo fisco (App);
     * 
     * Verificar se a NFS-e compartilhada pelo município preencheu alguma informação para o processo de
     * emissão.
     * Este campo não deve ser informado em NFS-e compartilhada com o ADN NFS-e.
     */
    public ?string $procEmi = null;

    /**
     * -
     */
    public ?string $cStat = null;

    /**
     * A data e hora do processamento (geração) da NFS-e deve ser anterior ou igual à data e hora da sua
     * recepção pelo Sistema Nacional NFS-e.
     */
    public ?string $dhProc = null;

    /**
     * -
     */
    public ?string $nDFSe = null;

    /**
     * -
     */
    public ?string $xOutInf = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\EmitData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\EmitData $emit = null;

    /**
     * Exceto para o campo vLiq, não é permitido informar os demais campos do grupo valores quando o
     * prestador é optante do simples nacional do tipo MEI (opSimpNac = 2).
     * @var \Nfse\Dto\NFSe\InfNFSe\ValoresData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\ValoresData $valores = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPSData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPSData $DPS = null;

}
