<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CExploracaoRodoviariaData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCExploracaoRodoviaria
 */
class CExploracaoRodoviariaData 
{
    /**
     * Categorias de veículos para cobrança:
     * 00 - Categoria de veículos (tipo não informado na nota de origem)
     * 01 - Automóvel, caminhonete e furgão;
     * 02 - Caminhão leve, ônibus, caminhão trator e furgão;
     * 03 - Automóvel e caminhonete com semireboque;
     * 04 - Caminhão, caminhão-trator, caminhão-trator com semi-reboque e ônibus;
     * 05 - Automóvel e caminhonete com reboque;
     * 06 - Caminhão com reboque;
     * 07 - Caminhão trator com semi-reboque;
     * 08 - Motocicletas, motonetas e bicicletas motorizadas;
     * 09 - Veículo especial;
     * 10 - Veículo Isento;
     */
    public string $categVeic;

    /**
     * Número de eixos para fins de cobrança
     */
    public string $nEixos;

    /**
     * Tipo de rodagem
     */
    public string $rodagem;

    /**
     * Placa do veículo
     */
    public string $sentido;

    /**
     * Placa do veículo
     */
    public string $placa;

    /**
     * Código de acesso gerado automaticamente pelo sistema emissor da concessionária.
     */
    public string $codAcessoPed;

    /**
     * Código de contrato gerado automaticamente pelo sistema nacional no cadastro da concessionária.
     */
    public string $codContrato;

}
