<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class FornecedorData extends Dto
{
    /**
     * CNPJ do fornecedor.
     */
    #[MapFrom('CNPJ')]
    public ?string $cnpj = null;

    /**
     * CPF do fornecedor.
     */
    #[MapFrom('CPF')]
    public ?string $cpf = null;

    /**
     * NIF do fornecedor.
     */
    #[MapFrom('NIF')]
    public ?string $nif = null;

    /**
     * Código do motivo de não informar o NIF.
     */
    #[MapFrom('cNaoNIF')]
    public ?string $codigoNaoNif = null;

    /**
     * CAEPF do fornecedor.
     */
    #[MapFrom('CAEPF')]
    public ?string $caepf = null;

    /**
     * Inscrição Municipal do fornecedor.
     */
    #[MapFrom('IM')]
    public ?string $inscricaoMunicipal = null;

    /**
     * Razão Social ou Nome do fornecedor.
     */
    #[MapFrom('xNome')]
    public ?string $nome = null;

    /**
     * Endereço do fornecedor.
     */
    #[MapFrom('endFornec')]
    public ?EnderecoData $endereco = null;

    /**
     * Telefone do fornecedor.
     */
    #[MapFrom('fone')]
    public ?string $telefone = null;

    /**
     * Email do fornecedor.
     */
    #[MapFrom('email')]
    public ?string $email = null;
}
