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
class InfNfseData extends Data
{
    public function __construct(
        /**
         * Identificador da NFS-e.
         */
        #[MapInputName('id')]
        public ?string $id = null,

        /**
         * Número da NFS-e.
         */
        #[MapInputName('nNFSe')]
        public ?string $numeroNfse = null,

        /**
         * Número do DFe.
         */
        #[MapInputName('nDFe')]
        public ?string $numeroDfse = null,

        /**
         * Código de verificação.
         */
        #[MapInputName('cVerif')]
        public ?string $codigoVerificacao = null,

        /**
         * Data e hora de processamento.
         */
        #[MapInputName('dhProc')]
        public ?string $dataProcessamento = null,

        /**
         * Ambiente gerador.
         */
        #[MapInputName('ambGer')]
        public ?int $ambienteGerador = null,

        /**
         * Versão do aplicativo.
         */
        #[MapInputName('verAplic')]
        public ?string $versaoAplicativo = null,

        /**
         * Processo de emissão.
         */
        #[MapInputName('procEmi')]
        public ?int $processoEmissao = null,

        /**
         * Local de emissão (Nome).
         */
        #[MapInputName('xLocEmi')]
        public ?string $localEmissao = null,

        /**
         * Local de prestação (Nome).
         */
        #[MapInputName('xLocPrestacao')]
        public ?string $localPrestacao = null,

        /**
         * Código do local de incidência.
         */
        #[MapInputName('cLocIncid')]
        public ?string $codigoLocalIncidencia = null,

        /**
         * Local de incidência (Nome).
         */
        #[MapInputName('xLocIncid')]
        public ?string $nomeLocalIncidencia = null,

        /**
         * Descrição da tributação nacional.
         */
        #[MapInputName('xTribNac')]
        public ?string $descricaoTributacaoNacional = null,

        /**
         * Descrição da tributação municipal.
         */
        #[MapInputName('xTribMun')]
        public ?string $descricaoTributacaoMunicipal = null,

        /**
         * Descrição da NBS.
         */
        #[MapInputName('xNBS')]
        public ?string $descricaoNbs = null,

        /**
         * Tipo de Emissão.
         */
        #[MapInputName('tpEmis')]
        public ?int $tipoEmissao = null,

        /**
         * Código de status.
         */
        #[MapInputName('cStat')]
        public ?int $codigoStatus = null,

        /**
         * Outras Informações.
         */
        #[MapInputName('xOutInf')]
        public ?string $outrasInformacoes = null,

        /**
         * Dados da DPS.
         */
        #[MapInputName('DPS')]
        public ?DpsData $dps = null,

        /**
         * Dados do emitente.
         */
        #[MapInputName('emit')]
        public ?EmitenteData $emitente = null,

        /**
         * Valores da NFS-e.
         */
        #[MapInputName('valores')]
        public ?ValoresNfseData $valores = null,
    ) {}
}
