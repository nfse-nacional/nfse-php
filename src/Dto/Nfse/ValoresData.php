<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ValoresData extends Dto
{
    /**
     * Valor do serviço prestado.
     */
    #[MapFrom('vServPrest')]
    public ?ValorServicoPrestadoData $valorServicoPrestado = null;

    /**
     * Descontos condicionados e incondicionados.
     */
    #[MapFrom('vDescCondIncond')]
    public ?DescontoData $desconto = null;

    /**
     * Ajuste da base de cálculo do ISSQN e/ou IBS/CBS.
     */
    #[MapFrom('vAjusteBC')]
    public ?AjusteBaseCalculoData $ajusteBaseCalculo = null;

    /**
     * Informações sobre a tributação do serviço.
     */
    #[MapFrom('trib')]
    public ?TributacaoData $tributacao = null;
}
