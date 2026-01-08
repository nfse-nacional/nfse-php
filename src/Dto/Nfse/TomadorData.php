<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\MotivoNaoNif;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class TomadorData extends Dto
{
    /**
     * CPF do tomador.
     * Obrigatório se pessoa física.
     */
    #[MapFrom('CPF')]
    public ?string $cpf = null;

    /**
     * CNPJ do tomador.
     * Obrigatório se pessoa jurídica.
     */
    #[MapFrom('CNPJ')]
    public ?string $cnpj = null;

    /**
     * Número de Identificação Fiscal (NIF) do tomador.
     * Não permitido se tpEmit=2.
     */
    #[MapFrom('NIF')]
    public ?string $nif = null;

    /**
     * Código do motivo de não informar o NIF.
     */
    #[MapFrom('cNaoNIF'), CastWith(EnumCaster::class, enumType: MotivoNaoNif::class)]
    public ?MotivoNaoNif $codigoNaoNif = null;

    /**
     * Cadastro de Atividade Econômica da Pessoa Física.
     */
    #[MapFrom('CAEPF')]
    public ?string $caepf = null;

    /**
     * Inscrição Municipal do tomador.
     */
    #[MapFrom('IM')]
    public ?string $inscricaoMunicipal = null;

    /**
     * Razão Social ou Nome do tomador.
     */
    #[MapFrom('xNome')]
    public ?string $nome = null;

    /**
     * Endereço do tomador.
     */
    #[MapFrom('end')]
    public ?EnderecoData $endereco = null;

    /**
     * Telefone do tomador.
     */
    #[MapFrom('fone')]
    public ?string $telefone = null;

    /**
     * Email do tomador.
     */
    #[MapFrom('email')]
    public ?string $email = null;
}
