<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS;

class PrestData 
{
    /**
     * CNPJ informado na DPS é inválido (verificar DV).
     */
    public ?string $CNPJ = null;

    /**
     * CPF informado na DPS é inválido (verificar DV).
     */
    public ?string $CPF = null;

    /**
     * Se o campo tpEmit for ígual a 1, então NIF do prestador não pode ser informado.
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
     * Se o emitente for o prestador de serviço (tpEmit = 1) e, se houver registro complementar do
     * contribuinte no CNC do município correspondente ao município emissor da DPS, então a IM deve ser
     * informada na DPS.
     * 
     * Utilizar o identificador federal (CNPJ ou CPF) do prestador de serviço e o codigo do município
     * emissor (cLocEmi), ambos informados na DPS, para identificar as ocorrências no CNC NFS-e. Se houver
     * pelo menos uma ocorrência, então o emitente da DPS deve informar o IM correspondente registrado no
     * CNC NFS-e, que identifique unicamente o registro complementar.
     * 
     * Exceto quando o emitente da DPS for MEI na data de competência da emissão da NFS-e.
     */
    public ?string $IM = null;

    /**
     * Se o emitente da DPS for o prestador de serviço (tpEmit for igual a 1), então o nome ou razão
     * social não deve ser informado.
     */
    public ?string $xNome = null;

    /**
     * Se o CNPJ ou CPF do prestador de serviço foi informado e o emitente da DPS não for o prestador
     * (tpEmit = 2 ou 3), então o grupo de informações de endereço nacional do prestador do serviço
     * deve ser informado obrigatoriamente.
     */
    public ?string $endNac = null;

    /**
     * -
     */
    public ?string $fone = null;

    /**
     * Email deve ser informado conforme estrutura (conter @, ponto etc.).
     */
    public ?string $email = null;

    /**
     * Se o emitente da DPS for o tomador ou intermediário (tpEmit = 2 ou 3) o grupo de informações do
     * endereço do prestador de serviço deve ser informado na DPS obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\EndData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\EndData $end = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\RegTribData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\RegTribData $regTrib = null;

}
