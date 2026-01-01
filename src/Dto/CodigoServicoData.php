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
class CodigoServicoData extends Data
{
    public function __construct(
        /**
         * Código de tributação nacional (LC 116/03).
         */
        #[MapInputName('cTribNac')]
        public ?string $codigoTributacaoNacional = null,

        /**
         * Código de tributação municipal.
         */
        #[MapInputName('cTribMun')]
        public ?string $codigoTributacaoMunicipal = null,

        /**
         * Descrição do serviço.
         */
        #[MapInputName('xDescServ')]
        public ?string $descricaoServico = null,

        /**
         * Código NBS (Nomenclatura Brasileira de Serviços).
         */
        #[MapInputName('cNBS')]
        public ?string $codigoNbs = null,

        /**
         * Código CNAE (Classificação Nacional de Atividades Econômicas).
         */
        #[MapInputName('cCNAE')]
        public ?string $codigoCnae = null,

        /**
         * Código interno do serviço no sistema do contribuinte.
         */
        #[MapInputName('cIntContrib')]
        public ?string $codigoInternoContribuinte = null,
    ) {}
}
