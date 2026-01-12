<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao\TribMunicipal;

use NFSe\Dto\Attributes\MapFrom;

/**
 * BeneficioMunicipal
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCBeneficioMunicipal
 */
class BeneficioMunicipal 
{
    /**
     * Identificação da Lei parametrizada pelo município que define o benefício.
     * Trata-se de um identificador único que foi gerado pelo Sistema Nacional no momento em
     * que o município de incidência do ISSQN incluiu o benefício no sistema.
     * Tem a seguinte regra de formação: 7 dígitos com o código IBGE do município + 4
     * dígitos com número sequencial.
     * Deve ser obtido da parametrização do município de incidência do ISSQN.
     */
    public \Nfse\Enums\V1_0_0\TSOpTipoBM $tpBM;

    /**
     * Identificador do benefício municipal parametrizado pelo município.
     */
    public string $nBM;

    /**
     * Valor monetário informado pelo emitente para redução da base de cálculo (BC) do ISSQN devido a
     * um Benefício Municipal (BM).
     */
    public ?string $vRedBCBM = null;

    /**
     * Valor percentual informado pelo emitente para redução da base de cálculo (BC) do ISSQN devido a
     * um Benefício Municipal (BM).
     */
    public ?string $pRedBCBM = null;

}
