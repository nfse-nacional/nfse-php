<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

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

    /**
     * e101101: Cancelamento de NFS-e
     * Tipo: TE101101
     */
    #[MapFrom('e101101')]
    public ?CancelamentoData $e101101 = null;

    /**
     * e105102: Cancelamento de NFS-e por Substituição
     * Tipo: TE105102
     */
    #[MapFrom('e105102')]
    public ?CancelamentoSubstituicaoData $e105102 = null;

    /**
     * e105104: Cancelamento de NFS-e Deferido por Análise Fiscal
     * Tipo: TE105104
     */
    #[MapFrom('e105104')]
    public ?AnaliseFiscalData $e105104 = null;

    /**
     * e105105: Cancelamento de NFS-e Indeferido por Análise Fiscal
     * Tipo: TE105105
     */
    #[MapFrom('e105105')]
    public ?AnaliseFiscalData $e105105 = null;

    /**
     * e305101: Cancelamento de NFS-e Por Ofício
     * Tipo: TE305101
     */
    #[MapFrom('e305101')]
    public ?CancelamentoPorOficioData $e305101 = null;

    /**
     * e907202: Código reservado (sem estrutura definida no schema v1.01)
     * Aguardando definição oficial do tipo TE907202
     */
    #[MapFrom('e907202')]
    public mixed $e907202 = null;

    /**
     * e967203: Código reservado (sem estrutura definida no schema v1.01)
     * Aguardando definição oficial do tipo TE967203
     */
    #[MapFrom('e967203')]
    public mixed $e967203 = null;
}
