<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Support\DTO\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class InfoComplData extends Dto
{
    /**
     * Oc. 0-1
     * Tam 1-40
     * Identificador do documento técnico.
     * Identificador de Documento de Responsabilidade Técnica:
     * ART, RRT, DRT, Outros.
     */
    #[MapFrom('idDocTec')]
    public ?string $idDocumentoTecnico = null;

    /**
     * Oc. 0-1
     * Tam 255
     * Chave da nota, número identificador da nota, número do contrato ou outro
     * identificador de documento emitido pelo prestador de serviços, que subsidia a
     * emissão dessa nota pelo tomador do serviço ou intermediário (preenchimento obrigatório
     * caso a nota esteja sendo emitida pelo Tomador ou intermediário do serviço).
     */
    #[MapFrom('docRef')]
    public ?string $documentoReferencia = null;

    /**
     * Número do pedido, ordem de compra, ordem de serviço ou projeto.
     */
    #[MapFrom('xPed')]
    public ?string $numeroPedido = null;

    /**
     * Itens do pedido citado em numeroPedido.
     *
     * @var string[]|null
     */
    #[MapFrom('gItemPed.xItemPed'), CastWith(ArrayCaster::class, itemType: 'string')]
    public ?array $itensPedido = null;

    /**
     * Oc. 0-1
     * Tam 255
     * Campo livre para preenchimento pelo contribuinte.
     */
    #[MapFrom('xInfComp')]
    public ?string $informacoesComplementares = null;
}
