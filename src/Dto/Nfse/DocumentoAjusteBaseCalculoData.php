<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoAjusteBaseCalculo;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DocumentoAjusteBaseCalculoData extends Dto
{
    /**
     * Tipo de ajuste da base de cálculo.
     */
    #[MapFrom('tpAjusteBC'), CastWith(EnumCaster::class, enumType: TipoAjusteBaseCalculo::class)]
    public ?TipoAjusteBaseCalculo $tipoAjusteBaseCalculo = null;

    /**
     * Descrição do ajuste quando o tipo informado exige detalhamento.
     */
    #[MapFrom('xTpAjusteBC')]
    public ?string $descricaoTipoAjusteBaseCalculo = null;

    /**
     * Valor monetário total do documento informado (R$).
     */
    #[MapFrom('vTotDoc')]
    public ?float $valorTotalDocumento = null;

    /**
     * Valor monetário utilizado para ajuste da base de cálculo (R$).
     */
    #[MapFrom('vAjusteAplic')]
    public ?float $valorAjusteAplicado = null;

    /**
     * Data de emissão do documento (AAAA-MM-DD).
     */
    #[MapFrom('dtEmiDoc')]
    public ?string $dataEmissaoDocumento = null;

    /**
     * Data de competência do documento (AAAA-MM-DD).
     */
    #[MapFrom('dtCompDoc')]
    public ?string $dataCompetenciaDocumento = null;

    /**
     * Documento fiscal eletrônico do repositório nacional.
     */
    #[MapFrom('dFeNacional')]
    public ?DfeNacionalData $dfeNacional = null;

    /**
     * Documento fiscal que não está no repositório nacional.
     */
    #[MapFrom('docFiscalOutro')]
    public ?DocumentoFiscalOutroData $documentoFiscalOutro = null;

    /**
     * Documento não fiscal.
     */
    #[MapFrom('docOutro')]
    public ?DocumentoOutroData $documentoOutro = null;

    /**
     * Fornecedor do serviço informado no documento.
     */
    #[MapFrom('fornec')]
    public ?FornecedorData $fornecedor = null;
}
