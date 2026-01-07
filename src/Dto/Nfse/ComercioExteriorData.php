<?php

namespace Nfse\Dto\Nfse;

use Nfse\Enums\ModoPrestacao;
use Nfse\Enums\MovimentacaoTemporariaBens;
use Nfse\Enums\TipoPessoa;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class ComercioExteriorData extends Dto
{
    /**
     * Modo de prestação do serviço.
     * 1 - Transfronteiriço
     * 2 - Consumo no Brasil
     * 3 - Presença Comercial no Exterior
     * 4 - Movimento Temporário de Pessoas Físicas
     */
    #[MapFrom('mdPrestacao'), CastWith(EnumCaster::class, enumType: ModoPrestacao::class)]
    public ?ModoPrestacao $modoPrestacao = null;

    /**
     * Vínculo entre as partes no negócio.
     * 1 - Sem vínculo
     * 2 - Com vínculo
     */
    #[MapFrom('vincPrest')]
    public ?int $vinculoPrestacao = null;

    /**
     * Tipo de pessoa do exportador.
     * 1 - Pessoa Jurídica
     * 2 - Pessoa Física
     */
    #[MapFrom('tpPessoaExport'), CastWith(EnumCaster::class, enumType: TipoPessoa::class)]
    public ?TipoPessoa $tipoPessoaExportador = null;

    /**
     * NIF do exportador.
     */
    #[MapFrom('NIFExport')]
    public ?string $nifExportador = null;

    /**
     * Código do país do exportador.
     */
    #[MapFrom('cPaisExport')]
    public ?string $codigoPaisExportador = null;

    /**
     * Código do mecanismo de apoio/fomento.
     */
    #[MapFrom('cMecAFComex')]
    public ?string $codigoMecanismoApoioFomento = null;

    /**
     * Número do enquadramento.
     */
    #[MapFrom('nEnquad')]
    public ?string $numeroEnquadramento = null;

    /**
     * Número do processo.
     */
    #[MapFrom('nProc')]
    public ?string $numeroProcesso = null;

    /**
     * Indicador de incentivo fiscal.
     * 1 - Sim
     * 2 - Não
     */
    #[MapFrom('indIncentivo')]
    public ?int $indicadorIncentivo = null;

    /**
     * Descrição do incentivo fiscal.
     */
    #[MapFrom('xDescIncentivo')]
    public ?string $descricaoIncentivo = null;

    /**
     * Código da moeda da transação (ISO 4217).
     */
    #[MapFrom('tpMoeda')]
    public ?string $tipoMoeda = null;

    /**
     * Valor do serviço na moeda estrangeira.
     */
    #[MapFrom('vServMoeda')]
    public ?float $valorServicoMoeda = null;

    /**
     * Mecanismo de apoio/fomento ao Comércio Exterior utilizado pelo prestador.
     */
    #[MapFrom('mecAFComexP')]
    public ?string $mecanismoApoioComexPrestador = null;

    /**
     * Mecanismo de apoio/fomento ao Comércio Exterior utilizado pelo tomador.
     */
    #[MapFrom('mecAFComexT')]
    public ?string $mecanismoApoioComexTomador = null;

    /**
     * Movimentação temporária de bens.
     */
    #[MapFrom('movTempBens'), CastWith(EnumCaster::class, enumType: MovimentacaoTemporariaBens::class)]
    public ?MovimentacaoTemporariaBens $movimentacaoTemporariaBens = null;

    /**
     * Número da Declaração de Importação (DI/DSI/DA/DRI-E) averbada.
     */
    #[MapFrom('nDI')]
    public ?string $numeroDeclaracaoImportacao = null;

    /**
     * Número do Registro de Exportação (RE) averbado.
     */
    #[MapFrom('nRE')]
    public ?string $numeroRegistroExportacao = null;

    /**
     * Compartilhamento de dados com o MDIC.
     * 1 - Sim
     * 2 - Não
     */
    #[MapFrom('mdic')]
    public ?string $mdic = null;
}
