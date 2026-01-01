<?php

namespace Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Size;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
/**
 * @typescript
 */
class EnderecoData extends Data
{
    public function __construct(
        /**
         * Código do município (IBGE).
         */
        #[MapInputName('endNac.cMun')]
        #[Nullable, StringType, Size(7)]
        public ?string $codigoMunicipio = null,

        /**
         * CEP.
         */
        #[MapInputName('endNac.CEP')]
        #[Nullable, StringType, Size(8)]
        public ?string $cep = null,

        /**
         * Logradouro.
         */
        #[MapInputName('xLgr')]
        #[Required, StringType, Max(255)]
        public ?string $logradouro = null,

        /**
         * Número.
         */
        #[MapInputName('nro')]
        #[Required, StringType, Max(60)]
        public ?string $numero = null,

        /**
         * Bairro.
         */
        #[MapInputName('xBairro')]
        #[Required, StringType, Max(60)]
        public ?string $bairro = null,

        /**
         * Complemento.
         */
        #[MapInputName('xCpl')]
        #[Nullable, StringType, Max(60)]
        public ?string $complemento = null,

        /**
         * Endereço no exterior.
         */
        #[MapInputName('endExt')]
        public ?EnderecoExteriorData $enderecoExterior = null,
    ) {}
}
