<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores;

class VServPrestData 
{
    /**
     * O valor recebido deve ser informado na DPS quando o intermediário do serviço for o emitente da DPS
     * (tpEmit = 3).
     */
    public ?string $vReceb = null;

    /**
     * vDR é:
     * um valor informado pelo emitente para dedução/redução da BC do ISSQN;
     * 
     * vCalcDR é:
     * o cálculo do valor de dedução/redução da BC do ISSQN:
     * 
     * 1) Quando o valor de dedução/redução for apurado a partir de um percentual informado na DPS,
     * calcular este percentual sobre o valor do serviço já abatido o valor do desconto incondicionado.
     * Ex:
     * Valor de dedução/redução = (Valor do serviço - valor desconto incodicional) x
     * % de dedução/redução.
     * 
     * VServ >= desconto incondicionado + Valor de dedução/redução
     * 
     * 2) Quando um ou mais documentos são informados pelo emitente na DPS para dedução/redução da BC
     * do ISSQN.
     * Neste caso o resultado do somatório é o valor deste campo do leiaute NFS-e;
     * 
     * ---------------------------
     * 
     * vInfoBM é:
     * um valor informado pelo emitente para reduzir a BC do ISSQN;
     * 
     * VCalcBM é:
     * o cálculo do valor de redução da BC do ISSQN a partir de benefício municipal:
     * 
     * 1) Quando o valor do benefício municipal for apurado a partir de um percentual parametrizado para
     * redução da base de cálculo, aplicar o percentual parametrizado sobre o valor do serviço já
     * abatidos os valores do desconto incondicionado e dedução/redução.
     * 
     * Ex:
     * Valor de benefício municipal = (Valor do serviço - valor desconto incodicional - valor de
     * dedução/redução) x % de benefício municipal.
     * 
     * VServ >= desconto incondicionado + Valor de dedução/redução + valor de benefício municipal.
     * 
     * 2) Quando um valor monetário de benefício municipal é informado pelo emitente na DPS para
     * redução da BC do ISSQN.
     */
    public ?string $vServ = null;

}
