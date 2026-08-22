<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class InfPedRegData extends Dto
{
    #[MapFrom('@attributes.Id')]
    public ?string $id = null;

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

    /**
     * === CANCELAMENTOS ===
     */
    #[MapFrom('e101101')]
    public ?CancelamentoData $e101101 = null;

    #[MapFrom('e105102')]
    public ?CancelamentoSubstituicaoData $e105102 = null;

    #[MapFrom('e101103')]
    public ?AnaliseFiscalSolicitacaoData $e101103 = null;

    #[MapFrom('e105104')]
    public ?AnaliseFiscalData $e105104 = null;

    #[MapFrom('e105105')]
    public ?AnaliseFiscalData $e105105 = null;

    #[MapFrom('e305101')]
    public ?CancelamentoPorOficioData $e305101 = null;

    /**
     * === CONFIRMAÇÕES ===
     */
    #[MapFrom('e202201')]
    public ?ConfirmacaoPrestadorData $e202201 = null;

    #[MapFrom('e203202')]
    public ?ConfirmacaoTomadorData $e203202 = null;

    #[MapFrom('e204203')]
    public ?ConfirmacaoIntermediarioData $e204203 = null;

    #[MapFrom('e205204')]
    public ?ConfirmacaoTacitaData $e205204 = null;

    /**
     * === REJEIÇÕES ===
     */
    #[MapFrom('e202205')]
    public ?RejeicaoPrestadorData $e202205 = null;

    #[MapFrom('e203206')]
    public ?RejeicaoTomadorData $e203206 = null;

    #[MapFrom('e204207')]
    public ?RejeicaoIntermediarioData $e204207 = null;

    #[MapFrom('e205208')]
    public ?AnulacaoRejeicaoData $e205208 = null;

    /**
     * === AÇÕES POR OFÍCIO ===
     */
    #[MapFrom('e305102')]
    public ?BloqueioPorOficioData $e305102 = null;

    #[MapFrom('e305103')]
    public ?DesbloqueioPorOficioData $e305103 = null;
}
