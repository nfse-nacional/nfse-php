<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class InfPedRegData extends Dto
{
    #[MapFrom('tpAmb')]
    public ?int $tipoAmbiente = null;

    #[MapFrom('verAplic')]
    public ?string $versaoAplicativo = null;

    #[MapFrom('dhEvento')]
    public ?string $dataHoraEvento = null;

    #[MapFrom('chNFSe')]
    public ?string $chaveNfse = null;

    #[MapFrom('CNPJAutor')]
    public ?string $cnpjAutor = null;

    #[MapFrom('CPFAutor')]
    public ?string $cpfAutor = null;

    #[MapFrom('nPedRegEvento')]
    public int $nPedRegEvento = 1;

    public string $tipoEvento = '101101';

    #[MapFrom('e101101')]
    public ?CancelamentoData $e101101 = null;
}
