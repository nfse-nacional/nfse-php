<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

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

    /**
     * Informações do Evento.
     */
    #[MapFrom('infEvento')]
    public ?InfEventoData $infEvento = null;
}
