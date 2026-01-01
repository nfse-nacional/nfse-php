<?php

namespace Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
/**
 * @typescript
 */
class ValorServicoPrestadoData extends Data
{
    public function __construct(
        /**
         * Valor recebido pelo intermediário.
         * Obrigatório se tpEmit = 3.
         */
        #[MapInputName('vReceb')]
        public ?float $valorRecebido = null,

        /**
         * Valor do serviço prestado.
         */
        #[MapInputName('vServ')]
        public ?float $valorServico = null,
    ) {}
}
