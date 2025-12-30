<?php

namespace Nfse\Nfse\Dto;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class InfDpsData extends Data
{
    public function __construct(
        /**
         * Identificador da DPS.
         * Formado por: "DPS" + Cód.Mun.Emi. + Tipo Inscrição + Inscrição + Série + Número.
         */
        #[MapInputName('@Id')]
        public ?string $id,

        /**
         * Ambiente de emissão.
         * 1 - Produção
         * 2 - Homologação
         */
        #[MapInputName('tpAmb')]
        public ?int $tipoAmbiente,

        /**
         * Data e hora de emissão da DPS.
         * Formato: AAAA-MM-DDThh:mm:ssTZD
         */
        #[MapInputName('dhEmi')]
        public ?string $dataEmissao,

        /**
         * Versão do aplicativo emissor.
         */
        #[MapInputName('verAplic')]
        public ?string $versaoAplicativo,

        /**
         * Série da DPS.
         */
        #[MapInputName('serie')]
        public ?string $serie,

        /**
         * Número da DPS.
         */
        #[MapInputName('nDPS')]
        public ?string $numeroDps,

        /**
         * Data de competência da DPS.
         * Formato: AAAA-MM-DD
         */
        #[MapInputName('dCompet')]
        public ?string $dataCompetencia,

        /**
         * Tipo de emitente da DPS.
         * 1 - Prestador
         * 2 - Tomador
         * 3 - Intermediário
         */
        #[MapInputName('tpEmit')]
        public ?int $tipoEmitente,

        /**
         * Código do município emissor da DPS (IBGE).
         */
        #[MapInputName('cLocEmi')]
        public ?string $codigoLocalEmissao,

        /**
         * Motivo da emissão da DPS pelo Tomador ou Intermediário.
         * Obrigatório se tpEmit = 2 ou 3.
         */
        #[MapInputName('cMotivoEmisTI')]
        public ?string $motivoEmissaoTomadorIntermediario,

        /**
         * Chave de acesso da NFS-e rejeitada.
         * Obrigatório se cMotivoEmisTI = 4.
         */
        #[MapInputName('chNFSeRej')]
        public ?string $chaveNfseRejeitada,

        /**
         * Informações de substituição de NFS-e.
         */
        #[MapInputName('subst')]
        public ?SubstituicaoData $substituicao,

        /**
         * Dados do prestador do serviço.
         */
        #[MapInputName('prest')]
        public ?PrestadorData $prestador,

        /**
         * Dados do tomador do serviço.
         */
        #[MapInputName('toma')]
        public ?TomadorData $tomador,

        /**
         * Dados do intermediário do serviço.
         */
        #[MapInputName('interm')]
        public ?IntermediarioData $intermediario,

        /**
         * Dados do serviço prestado.
         */
        #[MapInputName('serv')]
        public ?ServicoData $servico,

        /**
         * Valores do serviço e tributos.
         */
        #[MapInputName('valores')]
        public ?ValoresData $valores,
    ) {}
}
