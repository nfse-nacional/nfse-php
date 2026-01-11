<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CBeneficioMunicipalData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCBeneficioMunicipal
 */
class CBeneficioMunicipalData 
{
    /**
     * Identificador do benefício parametrizado pelo município.
     * 
     * Trata-se de um identificador único que foi gerado pelo Sistema Nacional no momento em
     * que o município de incidência do ISSQN incluiu o benefício no sistema.
     * 
     * Critério de formação do número de identificação de parâmetros municipais:
     * 7 dígitos - posição 1 a 7: número identificador do Município, conforme código
     * IBGE;
     * 2 dígitos - posições 8 e 9 : número identificador do tipo de parametrização
     * (01-legislação, 02-regimes especiais, 03-retenções, 04-outros benefícios);
     * 5 dígitos - posição 10 a 14 : número sequencial definido pelo sistema quando do
     * registro específico do parâmetro dentro do tipo de parametrização no sistema;
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
