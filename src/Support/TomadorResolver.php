<?php

namespace Nfse\Support;

use Nfse\Dto\Nfse\IntermediarioData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Support\Contracts\PessoaLookup;

/**
 * Preenche o tomador (ou o prestador/intermediário) da NFS-e a partir de um
 * CPF ou CNPJ, consultando uma fonte de dados cadastrais (PessoaLookup).
 *
 * Evita a digitação manual, que é a principal origem de rejeição de schema
 * (endereço com caractere inválido, CEP ou município errados). Fica ao lado
 * dos demais helpers de conveniência (IdGenerator, CpfCnpjFormatter) e não
 * participa do fluxo de assinatura/emissão: apenas produz DTOs prontos para o
 * array do DpsData.
 *
 * Exemplo:
 *   $resolver = TomadorResolver::comToken(getenv('CPFCNPJ_TOKEN'));
 *   $tomador  = $resolver->porCnpj('44827692000111');
 */
final class TomadorResolver
{
    public function __construct(private PessoaLookup $lookup) {}

    /**
     * Atalho que monta o resolver com a implementação de referência
     * (CPF.CNPJ). Veja CpfCnpjComBrLookup para os pacotes disponíveis.
     */
    public static function comToken(string $token, int $pacoteCpf = 3, int $pacoteCnpj = 5): self
    {
        return new self(new CpfCnpjComBrLookup($token, $pacoteCpf, $pacoteCnpj));
    }

    /** Tomador pessoa física a partir de um CPF (com ou sem máscara). */
    public function porCpf(string $cpf): TomadorData
    {
        $cpf = CpfCnpjFormatter::unformat($cpf);

        return new TomadorData($this->mapear($this->lookup->consultarCpf($cpf), cpf: $cpf));
    }

    /** Tomador pessoa jurídica a partir de um CNPJ (com ou sem máscara). */
    public function porCnpj(string $cnpj): TomadorData
    {
        $cnpj = CpfCnpjFormatter::unformat($cnpj);

        return new TomadorData($this->mapear($this->lookup->consultarCnpj($cnpj), cnpj: $cnpj));
    }

    /** Detecta o tipo pelo tamanho do documento (14 = CNPJ, senão CPF). */
    public function porDocumento(string $documento): TomadorData
    {
        $doc = CpfCnpjFormatter::unformat($documento);

        return strlen($doc) === 14 ? $this->porCnpj($doc) : $this->porCpf($doc);
    }

    /** Prestador pessoa jurídica a partir de um CNPJ. */
    public function prestadorPorCnpj(string $cnpj): PrestadorData
    {
        $cnpj = CpfCnpjFormatter::unformat($cnpj);

        return new PrestadorData($this->mapear($this->lookup->consultarCnpj($cnpj), cnpj: $cnpj));
    }

    /** Intermediário a partir de um CPF ou CNPJ (detecta pelo tamanho). */
    public function intermediarioPorDocumento(string $documento): IntermediarioData
    {
        $doc = CpfCnpjFormatter::unformat($documento);
        $dados = strlen($doc) === 14
            ? $this->mapear($this->lookup->consultarCnpj($doc), cnpj: $doc)
            : $this->mapear($this->lookup->consultarCpf($doc), cpf: $doc);

        return new IntermediarioData($dados);
    }

    /**
     * Traduz os dados normalizados da fonte para as chaves XML esperadas pelos
     * DTOs (o MapFrom cuida do resto). O código de município é o IBGE de 7
     * dígitos e o CEP entra apenas com dígitos.
     *
     * @param  array<string, mixed>  $d
     * @return array<string, mixed>
     */
    private function mapear(array $d, ?string $cpf = null, ?string $cnpj = null): array
    {
        $endNac = array_filter([
            'cMun' => isset($d['codigoMunicipioIbge']) ? (string) $d['codigoMunicipioIbge'] : null,
            'CEP' => isset($d['cep']) ? CpfCnpjFormatter::unformat((string) $d['cep']) : null,
        ], static fn ($v) => $v !== null && $v !== '');

        $end = array_filter([
            'xLgr' => $d['logradouro'] ?? null,
            'nro' => $d['numero'] ?? null,
            'xCpl' => $d['complemento'] ?? null,
            'xBairro' => $d['bairro'] ?? null,
            'endNac' => $endNac,
        ], static fn ($v) => $v !== null && $v !== '' && $v !== []);

        return array_filter([
            'CPF' => $cpf,
            'CNPJ' => $cnpj,
            'xNome' => $d['nome'] ?? null,
            'email' => $d['email'] ?? null,
            'fone' => $d['telefone'] ?? null,
            'end' => $end,
        ], static fn ($v) => $v !== null && $v !== '' && $v !== []);
    }
}
