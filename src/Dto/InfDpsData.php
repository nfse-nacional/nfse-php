<?php

namespace Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Size;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * @typescript
 */
#[MapName(SnakeCaseMapper::class)]
class InfDpsData extends Data
{
    public function __construct(
        /**
         * Identificador da DPS.
         * Formado por: "DPS" + Cód.Mun.Emi. + Tipo Inscrição + Inscrição + Série + Número.
         */
        #[MapInputName('@Id')]
        #[Required, StringType, Max(50)]
        public ?string $id,

        /**
         * Ambiente de emissão.
         * 1 - Produção
         * 2 - Homologação
         */
        #[MapInputName('tpAmb')]
        #[Required, IntegerType, In([1, 2])]
        public ?int $tipoAmbiente,

        /**
         * Data e hora de emissão da DPS.
         * Formato: AAAA-MM-DDThh:mm:ssTZD
         */
        #[MapInputName('dhEmi')]
        #[Required, StringType]
        public ?string $dataEmissao,

        /**
         * Versão do aplicativo emissor.
         */
        #[MapInputName('verAplic')]
        #[Required, StringType, Max(20)]
        public ?string $versaoAplicativo,

        /**
         * Série da DPS.
         */
        #[MapInputName('serie')]
        #[Required, StringType, Max(5)]
        public ?string $serie,

        /**
         * Número da DPS.
         */
        #[MapInputName('nDPS')]
        #[Required, StringType, Max(15)]
        public ?string $numeroDps,

        /**
         * Data de competência da DPS.
         * Formato: AAAA-MM-DD
         */
        #[MapInputName('dCompet')]
        #[Required, StringType]
        public ?string $dataCompetencia,

        /**
         * Tipo de emitente da DPS.
         * 1 - Prestador
         * 2 - Tomador
         * 3 - Intermediário
         */
        #[MapInputName('tpEmit')]
        #[Required, IntegerType, In([1, 2, 3])]
        public ?int $tipoEmitente,

        /**
         * Código do município emissor da DPS (IBGE).
         */
        #[MapInputName('cLocEmi')]
        #[Required, StringType, Size(7)]
        public ?string $codigoLocalEmissao,

        /**
         * Motivo da emissão da DPS pelo Tomador ou Intermediário.
         * Obrigatório se tpEmit = 2 ou 3.
         */
        #[MapInputName('cMotivoEmisTI')]
        #[Nullable, StringType, In(['1', '2', '3', '4'])]
        public ?string $motivoEmissaoTomadorIntermediario = null,

        /**
         * Chave de acesso da NFS-e rejeitada.
         * Obrigatório se cMotivoEmisTI = 4.
         */
        #[MapInputName('chNFSeRej')]
        #[Nullable, StringType, Size(44)]
        public ?string $chaveNfseRejeitada = null,

        /**
         * Informações de substituição de NFS-e.
         */
        #[MapInputName('subst')]
        public ?SubstituicaoData $substituicao = null,

        /**
         * Dados do prestador do serviço.
         */
        #[MapInputName('prest')]
        public ?PrestadorData $prestador = null,

        /**
         * Dados do tomador do serviço.
         */
        #[MapInputName('toma')]
        public ?TomadorData $tomador = null,

        /**
         * Dados do intermediário do serviço.
         */
        #[MapInputName('interm')]
        public ?IntermediarioData $intermediario = null,

        /**
         * Dados do serviço prestado.
         */
        #[MapInputName('serv')]
        public ?ServicoData $servico = null,

        /**
         * Valores do serviço e tributos.
         */
        #[MapInputName('valores')]
        public ?ValoresData $valores = null,
    ) {}
}
