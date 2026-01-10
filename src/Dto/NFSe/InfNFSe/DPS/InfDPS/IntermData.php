<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS;

class IntermData 
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
     * Se o campo tpEmit for ígual a 3, então NIF do intermediário não pode ser informado.
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
     * Se o emitente for o prestador de serviço (tpEmit = 3) e, se houver registro complementar do
     * contribuinte no CNC do município correspondente ao município emissor da DPS, então a IM deve ser
     * informada na DPS.
     * 
     * Utilizar o identificador federal (CNPJ ou CPF) do prestador de serviço e o codigo do município
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
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\EndData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\EndData $end = null;

}
