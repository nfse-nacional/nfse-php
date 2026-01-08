<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class EnderecoEmitenteData extends Dto
{
    /**
     * Logradouro.
     */
    #[MapFrom('xLgr')]
    public ?string $logradouro = null;

    /**
     * Número.
     */
    #[MapFrom('nro')]
    public ?string $numero = null;

    /**
     * Complemento.
     */
    #[MapFrom('xCpl')]
    public ?string $complemento = null;

    /**
     * Bairro.
     */
    #[MapFrom('xBairro')]
    public ?string $bairro = null;

    /**
     * Código do município (IBGE).
     */
    #[MapFrom('cMun')]
    public ?string $codigoMunicipio = null;

    /**
     * Sigla da UF.
     */
    #[MapFrom('UF')]
    public ?string $uf = null;

    /**
     * CEP.
     */
    #[MapFrom('CEP')]
    public ?string $cep = null;
}
