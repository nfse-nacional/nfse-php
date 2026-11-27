<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ObraData extends Dto
{
    /**
     * Inscrição imobiliária fiscal da obra.
     */
    #[MapFrom('inscImobFisc')]
    public ?string $inscricaoImobiliariaFiscal = null;

    /**
     * Número de identificação da obra (CNO ou CEI).
     */
    #[MapFrom('cObra')]
    public ?string $codigoObra = null;

    /**
     * Código do Cadastro Imobiliário Brasileiro (CIB).
     */
    #[MapFrom('cCIB')]
    public ?string $codigoCib = null;

    /**
     * Endereço da obra.
     */
    #[MapFrom('end')]
    public ?EnderecoData $endereco = null;
}
