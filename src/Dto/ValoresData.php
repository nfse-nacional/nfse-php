<?php

namespace Nfse\Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ValoresData extends Data
{
    public function __construct(
        /**
         * Valor do serviço prestado.
         */
        #[MapInputName('vServPrest')]
        #[Required]
        public ?ValorServicoPrestadoData $valorServicoPrestado,

        /**
         * Descontos condicionados e incondicionados.
         */
        #[MapInputName('vDescCondIncond')]
        public ?DescontoData $desconto,

        /**
         * Deduções e reduções da base de cálculo.
         */
        #[MapInputName('vDedRed')]
        public ?DeducaoReducaoData $deducaoReducao,

        /**
         * Informações sobre a tributação do serviço.
         */
        #[MapInputName('trib')]
        public ?TributacaoData $tributacao,
    ) {}
}
