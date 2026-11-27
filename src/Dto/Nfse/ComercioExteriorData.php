<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\ModoPrestacao;
use Nfse\Enums\MovimentacaoTemporariaBens;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ComercioExteriorData extends Dto
{
    /**
     * Modo de prestação do serviço.
     * 0 - Desconhecido
     * 1 - Transfronteiriço
     * 2 - Consumo no Brasil
     * 3 - Movimento temporário de pessoas físicas
     * 4 - Consumo no exterior
     */
    #[MapFrom('mdPrestacao'), CastWith(EnumCaster::class, enumType: ModoPrestacao::class)]
    public ?ModoPrestacao $modoPrestacao = null;

    /**
     * Vínculo entre as partes no negócio.
     * 0 - Sem vínculo
     * 1 - Controlada
     * 2 - Controladora
     * 3 - Coligada
     * 4 - Matriz
     * 5 - Filial ou sucursal
     * 6 - Outro vínculo
     * 9 - Desconhecido
     */
    #[MapFrom('vincPrest')]
    public ?int $vinculoPrestacao = null;

    /**
     * Código da moeda da transação (tabela do Banco Central).
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
     * Vínculo da operação à movimentação temporária de bens.
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
     * Envio das informações ao MDIC.
     * 0 - Não enviar
     * 1 - Enviar
     */
    #[MapFrom('mdic')]
    public ?string $mdic = null;

    /**
     * Número da fatura. Schema 20261124.
     */
    #[MapFrom('nFatura')]
    public ?string $numeroFatura = null;

    /**
     * Valor da fatura. Schema 20261124.
     */
    #[MapFrom('vFatura')]
    public ?float $valorFatura = null;

    /**
     * Número da DUIMP. Schema 20261124.
     */
    #[MapFrom('nDUIMP')]
    public ?string $numeroDuimp = null;

    /**
     * Número da DU-E. Schema 20261124.
     */
    #[MapFrom('nDUE')]
    public ?string $numeroDue = null;

    /**
     * Número do contrato de câmbio. Schema 20261124.
     */
    #[MapFrom('nContCambio')]
    public ?string $numeroContratoCambio = null;
}
