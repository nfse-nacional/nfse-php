<?php

namespace Nfse\Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ServicoData extends Data
{
    public function __construct(
        /**
         * Local da prestação do serviço.
         */
        #[MapInputName('locPrest')]
        public ?LocalPrestacaoData $localPrestacao,

        /**
         * Código do serviço prestado.
         */
        #[MapInputName('cServ')]
        public ?CodigoServicoData $codigoServico,

        /**
         * Informações de comércio exterior.
         */
        #[MapInputName('comExt')]
        public ?ComercioExteriorData $comercioExterior,

        /**
         * Informações da obra.
         */
        #[MapInputName('obra')]
        public ?ObraData $obra,

        /**
         * Informações de atividade/evento.
         */
        #[MapInputName('atvEvento')]
        public ?AtividadeEventoData $atividadeEvento,

        /**
         * Informações complementares do serviço.
         */
        #[MapInputName('infoComplem')]
        #[Nullable, StringType, Max(2000)]
        public ?string $informacoesComplementares,

        /**
         * Identificador do documento técnico.
         */
        #[MapInputName('idDocTec')]
        public ?string $idDocumentoTecnico,

        /**
         * Documento de referência.
         * Obrigatório se tpEmit = 2 ou 3.
         */
        #[MapInputName('docRef')]
        public ?string $documentoReferencia,

        /**
         * Outras informações complementares.
         */
        #[MapInputName('xInfComp')]
        public ?string $descricaoInformacoesComplementares,
    ) {}
}
