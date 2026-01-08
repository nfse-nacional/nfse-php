<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\AmbienteGerador;
use Nfse\Enums\ProcessoEmissao;
use Nfse\Enums\CodigoStatus;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class InfNfseData extends Dto
{
    /**
     * Identificador da NFS-e.
     */
    #[MapFrom('@attributes.Id')]
    public ?string $id = null;

    /**
     * Número da NFS-e.
     */
    #[MapFrom('nNFSe')]
    public ?string $numeroNfse = null;

    /**
     * Número do DFe.
     */
    #[MapFrom('nDFSe')]
    public ?string $numeroDfse = null;

    /**
     * Código de verificação.
     */
    #[MapFrom('cVerif')]
    public ?string $codigoVerificacao = null;

    /**
     * Data e hora de processamento.
     */
    #[MapFrom('dhProc')]
    public ?string $dataProcessamento = null;

    /**
     * Ambiente gerador.
     */
    #[MapFrom('ambGer'), CastWith(EnumCaster::class, enumType: AmbienteGerador::class)]
    public ?AmbienteGerador $ambienteGerador = null;

    /**
     * Versão do aplicativo.
     */
    #[MapFrom('verAplic')]
    public ?string $versaoAplicativo = null;

    /**
     * Processo de emissão.
     */
    #[MapFrom('procEmi'), CastWith(EnumCaster::class, enumType: ProcessoEmissao::class)]
    public ?ProcessoEmissao $processoEmissao = null;

    /**
     * Local de emissão (Nome).
     */
    #[MapFrom('xLocEmi')]
    public ?string $localEmissao = null;

    /**
     * Local de prestação (Nome).
     */
    #[MapFrom('xLocPrestacao')]
    public ?string $localPrestacao = null;

    /**
     * Código do local de incidência.
     */
    #[MapFrom('cLocIncid')]
    public ?string $codigoLocalIncidencia = null;

    /**
     * Local de incidência (Nome).
     */
    #[MapFrom('xLocIncid')]
    public ?string $nomeLocalIncidencia = null;

    /**
     * Descrição da tributação nacional.
     */
    #[MapFrom('xTribNac')]
    public ?string $descricaoTributacaoNacional = null;

    /**
     * Descrição da tributação municipal.
     */
    #[MapFrom('xTribMun')]
    public ?string $descricaoTributacaoMunicipal = null;

    /**
     * Descrição da NBS.
     */
    #[MapFrom('xNBS')]
    public ?string $descricaoNbs = null;

    /**
     * Tipo de Emissão.
     */
    #[MapFrom('tpEmis')]
    public ?int $tipoEmissao = null;

    /**
     * Código de status.
     */
    #[MapFrom('cStat'), CastWith(EnumCaster::class, enumType: CodigoStatus::class)]
    public ?CodigoStatus $codigoStatus = null;

    /**
     * Outras Informações.
     */
    #[MapFrom('xOutInf')]
    public ?string $outrasInformacoes = null;

    /**
     * Dados da DPS.
     */
    #[MapFrom('DPS')]
    public ?DpsData $dps = null;

    /**
     * Dados do emitente.
     */
    #[MapFrom('emit')]
    public ?EmitenteData $emitente = null;

    /**
     * Valores da NFS-e.
     */
    #[MapFrom('valores')]
    public ?ValoresNfseData $valores = null;
}
