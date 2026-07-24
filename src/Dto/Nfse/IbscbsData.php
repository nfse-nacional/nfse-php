<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\IndicadorDestinatario;
use Nfse\Enums\TipoEnteGovernamental;
use Nfse\Enums\TipoOperacaoRtc;
use Nfse\Support\DTO\ArrayCaster;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class IbscbsData extends Dto
{
    /**
     * Indicador da finalidade da emissão de NFS-e.
     * 0 - NFS-e regular
     */
    #[MapFrom('finNFSe')]
    public ?string $finalidadeNfse = null;

    /**
     * Indica operação de uso ou consumo pessoal (art. 57).
     * 0 - Não
     * 1 - Sim
     */
    #[MapFrom('indFinal')]
    public ?int $indicadorUsoConsumoPessoal = null;

    /**
     * Código indicador da operação de fornecimento, conforme tabela
     * "código indicador de operação" (Anexo VII).
     */
    #[MapFrom('cIndOp')]
    public ?string $codigoIndicadorOperacao = null;

    /**
     * Tipo de Operação com Entes Governamentais ou outros serviços sobre bens imóveis.
     */
    #[MapFrom('tpOper'), CastWith(EnumCaster::class, enumType: TipoOperacaoRtc::class)]
    public ?TipoOperacaoRtc $tipoOperacao = null;

    /**
     * Chaves de acesso das NFS-e referenciadas.
     *
     * @var string[]|null
     */
    #[MapFrom('gRefNFSe.refNFSe')]
    public ?array $chavesNfseReferenciadas = null;

    /**
     * Tipo de ente governamental.
     * Informado apenas no caso de compras governamentais.
     */
    #[MapFrom('tpEnteGov'), CastWith(EnumCaster::class, enumType: TipoEnteGovernamental::class)]
    public ?TipoEnteGovernamental $tipoEnteGovernamental = null;

    /**
     * A respeito do destinatário dos serviços.
     */
    #[MapFrom('indDest'), CastWith(EnumCaster::class, enumType: IndicadorDestinatario::class)]
    public ?IndicadorDestinatario $indicadorDestinatario = null;

    /**
     * Dados do destinatário do serviço.
     * Só deve ser identificado quando indDest = 1.
     */
    #[MapFrom('dest')]
    public ?TomadorData $destinatario = null;

    /**
     * Informações de operações relacionadas a bens imóveis, exceto obras.
     */
    #[MapFrom('imovel')]
    public ?ImovelData $imovel = null;

    /**
     * Documentos referenciados de reembolso, repasse ou ressarcimento.
     *
     * @var ReembolsoDocumentoData[]|null
     */
    #[MapFrom('valores.gReeRepRes.documentos'), CastWith(ArrayCaster::class, itemType: ReembolsoDocumentoData::class)]
    public ?array $documentosReembolso = null;

    /**
     * Código de Situação Tributária do IBS e da CBS.
     */
    #[MapFrom('valores.trib.gIBSCBS.CST')]
    public ?string $cst = null;

    /**
     * Código de Classificação Tributária do IBS e da CBS.
     */
    #[MapFrom('valores.trib.gIBSCBS.cClassTrib')]
    public ?string $codigoClassificacaoTributaria = null;

    /**
     * Código e classificação do crédito presumido do IBS e da CBS.
     */
    #[MapFrom('valores.trib.gIBSCBS.cCredPres')]
    public ?string $codigoCreditoPresumido = null;

    /**
     * Código de Situação Tributária do IBS e da CBS de tributação regular.
     */
    #[MapFrom('valores.trib.gIBSCBS.gTribRegular.CSTReg')]
    public ?string $cstTributacaoRegular = null;

    /**
     * Código da Classificação Tributária do IBS e da CBS de tributação regular.
     */
    #[MapFrom('valores.trib.gIBSCBS.gTribRegular.cClassTribReg')]
    public ?string $codigoClassificacaoTributariaRegular = null;

    /**
     * Percentual de diferimento para o IBS estadual.
     */
    #[MapFrom('valores.trib.gIBSCBS.gDif.pDifUF')]
    public ?float $percentualDiferimentoUf = null;

    /**
     * Percentual de diferimento para o IBS municipal.
     */
    #[MapFrom('valores.trib.gIBSCBS.gDif.pDifMun')]
    public ?float $percentualDiferimentoMunicipal = null;

    /**
     * Percentual de diferimento para a CBS.
     */
    #[MapFrom('valores.trib.gIBSCBS.gDif.pDifCBS')]
    public ?float $percentualDiferimentoCbs = null;
}
