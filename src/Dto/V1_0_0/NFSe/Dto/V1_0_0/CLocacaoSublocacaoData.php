<?php

namespace NFSe\Dto\V1_0_0;

/**
 * CLocacaoSublocacaoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCLocacaoSublocacao
 */
class CLocacaoSublocacaoData 
{
    /**
     * Categoria do serviço
     */
    public string $categ;

    /**
     * Tipo de objetos da locação, sublocação, arrendamento, direito de passagem ou permissão de uso
     */
    public string $objeto;

    /**
     * Extensão total da ferrovia, rodovia, cabos, dutos ou condutos
     */
    public string $extensao;

    /**
     * Número total de postes
     */
    public string $nPostes;

}
