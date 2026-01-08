<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class IntermediarioData extends Dto
{
    /**
     * CNPJ do intermediário.
     * Obrigatório se pessoa jurídica.
     */
    #[MapFrom('CNPJ')]
    public ?string $cnpj = null;

    /**
     * CPF do intermediário.
     * Obrigatório se pessoa física.
     */
    #[MapFrom('CPF')]
    public ?string $cpf = null;

    /**
     * Número de Identificação Fiscal (NIF) do intermediário.
     * Não permitido se tpEmit=3.
     */
    #[MapFrom('NIF')]
    public ?string $nif = null;

    /**
     * Código do motivo de não informar o NIF.
     */
    #[MapFrom('cNaoNIF')]
    public ?string $codigoNaoNif = null;

    /**
     * Cadastro de Atividade Econômica da Pessoa Física.
     */
    #[MapFrom('CAEPF')]
    public ?string $caepf = null;

    /**
     * Inscrição Municipal do intermediário.
     */
    #[MapFrom('IM')]
    public ?string $inscricaoMunicipal = null;

    /**
     * Razão Social ou Nome do intermediário.
     */
    #[MapFrom('xNome')]
    public ?string $nome = null;

    /**
     * Endereço do intermediário.
     */
    #[MapFrom('end')]
    public ?EnderecoData $endereco = null;

    /**
     * Telefone do intermediário.
     */
    #[MapFrom('fone')]
    public ?string $telefone = null;

    /**
     * Email do intermediário.
     */
    #[MapFrom('email')]
    public ?string $email = null;
}
