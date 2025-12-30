<?php

namespace Nfse\Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class EnderecoData extends Data
{
    public function __construct(
        /**
         * Código do município (IBGE).
         */
        #[MapInputName('endNac.cMun')]
        public ?string $codigoMunicipio,

        /**
         * CEP.
         */
        #[MapInputName('endNac.CEP')]
        public ?string $cep,

        /**
         * Logradouro.
         */
        #[MapInputName('xLgr')]
        public ?string $logradouro,

        /**
         * Número.
         */
        #[MapInputName('nro')]
        public ?string $numero,

        /**
         * Bairro.
         */
        #[MapInputName('xBairro')]
        public ?string $bairro,

        /**
         * Complemento.
         */
        #[MapInputName('xCpl')]
        public ?string $complemento,

        /**
         * Endereço no exterior.
         */
        #[MapInputName('endExt')]
        public ?EnderecoExteriorData $enderecoExterior,
    ) {}
}
