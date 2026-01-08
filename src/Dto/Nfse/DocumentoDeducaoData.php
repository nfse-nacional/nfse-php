<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoDeducaoReducao;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DocumentoDeducaoData extends Dto
{
    /**
     * Chave de NFS-e.
     */
    #[MapFrom('chNFSe')]
    public ?string $chaveNfse = null;

    /**
     * Chave de NF-e.
     */
    #[MapFrom('chNFe')]
    public ?string $chaveNfe = null;

    /**
     * Tipo de dedução/redução.
     */
    #[MapFrom('tpDedRed'), CastWith(EnumCaster::class, enumType: TipoDeducaoReducao::class)]
    public ?TipoDeducaoReducao $tipoDeducaoReducao = null;

    /**
     * Descrição de outras deduções.
     */
    #[MapFrom('xDescOutDed')]
    public ?string $descricaoOutrasDeducoes = null;

    /**
     * Data de emissão do documento.
     */
    #[MapFrom('dEmiDoc')]
    public ?string $dataEmissaoDocumento = null;

    /**
     * Valor dedutível/redutível.
     */
    #[MapFrom('vDedutivelRedutivel')]
    public ?float $valorDedutivelRedutivel = null;

    /**
     * Valor de dedução/redução.
     */
    #[MapFrom('vDeducaoReducao')]
    public ?float $valorDeducaoReducao = null;

    /**
     * Informações do fornecedor.
     */
    #[MapFrom('fornec')]
    public ?FornecedorData $fornecedor = null;
}
