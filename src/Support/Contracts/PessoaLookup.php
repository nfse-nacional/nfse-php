<?php

namespace Nfse\Support\Contracts;

/**
 * Fonte de dados cadastrais de CPF/CNPJ para preencher o tomador (ou o
 * prestador/intermediário) da NFS-e a partir do documento.
 *
 * A interface desacopla o SDK do provedor: qualquer serviço de consulta pode
 * ser plugado, bastando devolver os campos normalizados abaixo. Isso também
 * permite mockar a fonte nos testes.
 */
interface PessoaLookup
{
    /**
     * Consulta um CPF e devolve os dados cadastrais normalizados.
     *
     * Chaves esperadas no retorno (as ausentes vêm como null):
     * nome, logradouro, numero, complemento, bairro, cep, codigoMunicipioIbge.
     *
     * @param  string  $cpf  CPF com ou sem máscara.
     * @return array<string, mixed>
     */
    public function consultarCpf(string $cpf): array;

    /**
     * Consulta um CNPJ e devolve os dados cadastrais normalizados.
     *
     * Chaves esperadas no retorno (as ausentes vêm como null):
     * nome (razão social), fantasia, logradouro, numero, complemento, bairro,
     * cep, codigoMunicipioIbge, e — quando o pacote consultado os fornecer —
     * simplesNacional (bool), situacao (string) e porte (string).
     *
     * @param  string  $cnpj  CNPJ com ou sem máscara.
     * @return array<string, mixed>
     */
    public function consultarCnpj(string $cnpj): array;
}
