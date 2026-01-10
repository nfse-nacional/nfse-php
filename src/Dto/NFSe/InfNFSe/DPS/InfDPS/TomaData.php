<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS;

class TomaData 
{
    /**
     * CNPJ informado na DPS é inválido (verificar DV).
     */
    public ?string $CNPJ = null;

    /**
     * 
     */
    public ?string $CPF = null;

    /**
     * Se o campo tpEmit for ígual a 2, então NIF do tomador não pode ser informado.
     */
    public ?string $NIF = null;

    /**
     * 
     */
    public ?string $cNaoNIF = null;

    /**
     * -
     */
    public ?string $CAEPF = null;

    /**
     * Se o emitente for o prestador de serviço (tpEmit = 2) e, se houver registro complementar do
     * contribuinte no CNC do município correspondente ao município emissor da DPS, então a IM deve ser
     * informada na DPS.
     * 
     * Utilizar o identificador federal (CNPJ ou CPF) do tomador de serviço e o codigo do município
     * emissor (cLocEmi), ambos informados na DPS, para identificar as ocorrências no CNC NFS-e. Se houver
     * pelo menos uma ocorrência então o emitente da DPS deve informar o IM correspondente registrado no
     * CNC NFS-e, que identifique unicamente o registro complementar.
     * 
     * Exceto quando o emitente da DPS for MEI na data de competência da emissão da NFS-e.
     */
    public ?string $IM = null;

    /**
     * Se NIF for preenchido então o campo xNome deve ser preenchido obrigatoriamente.
     */
    public ?string $xNome = null;

    /**
     * -
     */
    public ?string $fone = null;

    /**
     * Email deve ser informado conforme estrutura (conter @, ponto etc.).
     */
    public ?string $email = null;

    /**
     * Quando o emitente da DPS informar um subitem da lista de serviço cuja incidência do ISSQN ocorra
     * no local do estabelecimento/endereço do tomador, conforme planilha MUN.INCID_INFO.SERV., o
     * endereço do tomador deve ser obrigatoriamente informado.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\EndData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\EndData $end = null;

}
