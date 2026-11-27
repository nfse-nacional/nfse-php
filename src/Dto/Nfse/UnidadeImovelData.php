<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Support\DTO\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class UnidadeImovelData extends Dto
{
    /**
     * Inscrição imobiliária fiscal da unidade.
     */
    #[MapFrom('inscImobFisc')]
    public ?string $inscricaoImobiliariaFiscal = null;

    /**
     * Código do Cadastro Imobiliário Brasileiro (CIB).
     */
    #[MapFrom('cCIB')]
    public ?string $codigoCib = null;

    /**
     * Endereço da unidade quando não há CIB.
     */
    #[MapFrom('end')]
    public ?EnderecoData $endereco = null;

    /**
     * Parcelas que não entram na base de cálculo da locação.
     *
     * @var AjusteBaseCalculoLocacaoImovelData[]|null
     */
    #[MapFrom('gAjusteBCLocImoveis'), CastWith(ArrayCaster::class, itemType: AjusteBaseCalculoLocacaoImovelData::class)]
    public ?array $ajustesBaseCalculoLocacao = null;
}
