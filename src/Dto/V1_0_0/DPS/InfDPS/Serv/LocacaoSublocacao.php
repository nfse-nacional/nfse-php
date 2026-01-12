<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\Serv;

use NFSe\Dto\Attributes\MapFrom;

/**
 * LocacaoSublocacao
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCLocacaoSublocacao
 */
class LocacaoSublocacao 
{
    /**
     * Categoria do serviço
     */
    public \Nfse\Enums\V1_0_0\TSCategoriaServico $categ;

    /**
     * Tipo de objetos da locação, sublocação, arrendamento, direito de passagem ou permissão de uso
     */
    public \Nfse\Enums\V1_0_0\TCObjetoLocacao $objeto;

    /**
     * Extensão total da ferrovia, rodovia, cabos, dutos ou condutos
     */
    public string $extensao;

    /**
     * Número total de postes
     */
    public string $nPostes;

}
