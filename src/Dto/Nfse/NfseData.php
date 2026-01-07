<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class NfseData extends Dto
{
    /**
     * Versão do leiaute.
     */
    #[MapFrom('@attributes.versao')]
    public ?string $versao = null;

    /**
     * Informações da NFS-e.
     */
    #[MapFrom('infNFSe')]
    public ?InfNfseData $infNfse = null;
}
