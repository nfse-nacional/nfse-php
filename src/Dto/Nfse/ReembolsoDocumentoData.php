<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoChaveDFe;
use Nfse\Enums\TipoReembolsoRepasseRessarcimento;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ReembolsoDocumentoData extends Dto
{
    /**
     * Documento fiscal a que se refere a chave de DF-e do Repositório Nacional.
     */
    #[MapFrom('dFeNacional.tipoChaveDFe'), CastWith(EnumCaster::class, enumType: TipoChaveDFe::class)]
    public ?TipoChaveDFe $tipoChaveDfe = null;

    /**
     * Descrição do DF-e a que se refere a chave.
     * Preenchido apenas quando tipoChaveDFe = 9.
     */
    #[MapFrom('dFeNacional.xTipoChaveDFe')]
    public ?string $descricaoTipoChaveDfe = null;

    /**
     * Chave do Documento Fiscal eletrônico do repositório nacional.
     */
    #[MapFrom('dFeNacional.chaveDFe')]
    public ?string $chaveDfe = null;

    /**
     * Código do município emissor do documento fiscal que não se encontra
     * no repositório nacional.
     */
    #[MapFrom('docFiscalOutro.cMunDocFiscal')]
    public ?string $codigoMunicipioDocumentoFiscal = null;

    /**
     * Número do documento fiscal que não se encontra no repositório nacional.
     */
    #[MapFrom('docFiscalOutro.nDocFiscal')]
    public ?string $numeroDocumentoFiscal = null;

    /**
     * Descrição do documento fiscal.
     */
    #[MapFrom('docFiscalOutro.xDocFiscal')]
    public ?string $descricaoDocumentoFiscal = null;

    /**
     * Número do documento não fiscal.
     */
    #[MapFrom('docOutro.nDoc')]
    public ?string $numeroDocumento = null;

    /**
     * Descrição do documento não fiscal.
     */
    #[MapFrom('docOutro.xDoc')]
    public ?string $descricaoDocumento = null;

    /**
     * Fornecedor do documento referenciado.
     */
    #[MapFrom('fornec')]
    public ?FornecedorData $fornecedor = null;

    /**
     * Data da emissão do documento.
     * Formato: AAAA-MM-DD
     */
    #[MapFrom('dtEmiDoc')]
    public ?string $dataEmissaoDocumento = null;

    /**
     * Data da competência do documento.
     * Formato: AAAA-MM-DD
     */
    #[MapFrom('dtCompDoc')]
    public ?string $dataCompetenciaDocumento = null;

    /**
     * Tipo de reembolso, repasse ou ressarcimento.
     */
    #[MapFrom('tpReeRepRes'), CastWith(EnumCaster::class, enumType: TipoReembolsoRepasseRessarcimento::class)]
    public ?TipoReembolsoRepasseRessarcimento $tipoReembolso = null;

    /**
     * Descrição do reembolso ou ressarcimento.
     * Só deve ser informada quando tpReeRepRes = 99.
     */
    #[MapFrom('xTpReeRepRes')]
    public ?string $descricaoTipoReembolso = null;

    /**
     * Valor monetário utilizado para não inclusão na base de cálculo do ISSQN,
     * do IBS e da CBS da NFS-e que está sendo emitida (R$).
     */
    #[MapFrom('vlrReeRepRes')]
    public ?float $valorReembolso = null;
}
