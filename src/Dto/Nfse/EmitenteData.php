<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class EmitenteData extends Dto
{
    /**
     * CNPJ do emitente.
     */
    #[MapFrom('CNPJ')]
    public ?string $cnpj = null;

    /**
     * CPF do emitente.
     */
    #[MapFrom('CPF')]
    public ?string $cpf = null;

    /**
     * Inscrição Municipal do emitente.
     */
    #[MapFrom('IM')]
    public ?string $inscricaoMunicipal = null;

    /**
     * Razão Social ou Nome do emitente.
     */
    #[MapFrom('xNome')]
    public ?string $nome = null;

    /**
     * Nome Fantasia do emitente.
     */
    #[MapFrom('xFant')]
    public ?string $nomeFantasia = null;

    /**
     * Endereço do emitente.
     */
    #[MapFrom('enderNac')]
    public ?EnderecoEmitenteData $endereco = null;

    /**
     * Telefone do emitente.
     */
    #[MapFrom('fone')]
    public ?string $telefone = null;

    /**
     * Email do emitente.
     */
    #[MapFrom('email')]
    public ?string $email = null;
}
