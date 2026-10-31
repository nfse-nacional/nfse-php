<?php

namespace Nfse\Support;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Support\Contracts\PessoaLookup;

/**
 * Implementação de referência da fonte de dados cadastrais usando a API da
 * CPF.CNPJ (https://www.cpfcnpj.com.br).
 *
 * Autenticação por token no caminho da URL (o token é atrelado ao IP de
 * origem da requisição):
 *
 *     GET https://api.cpfcnpj.com.br/{token}/{pacote}/{documento}
 *
 * O token é obtido no painel, em API > Tokens. Para desenvolvimento há um
 * token público de testes que devolve dados fictícios (ver TOKEN_TESTES).
 *
 * Pacotes usados por padrão:
 *  - CPF: 3 (nome e endereço). Use 1 para obter somente o nome.
 *  - CNPJ: 5 (razão social e endereço). Use 6 para incluir Simples Nacional,
 *    situação cadastral, porte e natureza jurídica.
 */
final class CpfCnpjComBrLookup implements PessoaLookup
{
    private const BASE_URI = 'https://api.cpfcnpj.com.br/';

    /** Token público de testes (retorna dados fictícios). */
    public const TOKEN_TESTES = '5ae973d7a997af13f0aaf2bf60e65803';

    private ClientInterface $http;

    /**
     * @param  string  $token  Token da API cpfcnpj.com.br.
     * @param  int  $pacoteCpf  Pacote de consulta de CPF (1 = só nome, 3 = nome e endereço).
     * @param  int  $pacoteCnpj  Pacote de consulta de CNPJ (5 = razão e endereço, 6 = completo com Simples Nacional).
     * @param  ClientInterface|null  $http  Cliente HTTP injetável (facilita testes).
     */
    public function __construct(
        private string $token,
        private int $pacoteCpf = 3,
        private int $pacoteCnpj = 5,
        ?ClientInterface $http = null,
    ) {
        $this->http = $http ?? new Client(['base_uri' => self::BASE_URI, 'timeout' => 20]);
    }

    /**
     * @return array<string, mixed>
     */
    public function consultarCpf(string $cpf): array
    {
        $d = $this->get($this->pacoteCpf, CpfCnpjFormatter::unformat($cpf));

        return [
            'nome' => $d['nome'] ?? null,
            'logradouro' => $d['endereco'] ?? null,
            'numero' => $d['numero'] ?? null,
            'complemento' => $d['complemento'] ?? null,
            'bairro' => $d['bairro'] ?? null,
            'cep' => $d['cep'] ?? null,
            'codigoMunicipioIbge' => $d['ibge'] ?? null,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function consultarCnpj(string $cnpj): array
    {
        $d = $this->get($this->pacoteCnpj, CpfCnpjFormatter::unformat($cnpj));
        $end = is_array($d['matrizEndereco'] ?? null) ? $d['matrizEndereco'] : [];

        return [
            'nome' => $d['razao'] ?? null,
            'fantasia' => $d['fantasia'] ?? null,
            'logradouro' => $end['logradouro'] ?? null,
            'numero' => $end['numero'] ?? null,
            'complemento' => $end['complemento'] ?? null,
            'bairro' => $end['bairro'] ?? null,
            'cep' => $end['cep'] ?? null,
            'codigoMunicipioIbge' => $d['ibge']['cidade']['ibge_id'] ?? null,
            'simplesNacional' => isset($d['simplesNacional']['optante'])
                ? mb_strtolower((string) $d['simplesNacional']['optante']) === 'sim'
                : null,
            'situacao' => $d['situacao']['nome'] ?? null,
            'porte' => $d['porte']['descricao'] ?? null,
        ];
    }

    /**
     * Executa a consulta e devolve o JSON já validado.
     *
     * @return array<string, mixed>
     *
     * @throws NfseApiException Quando a API responde erro (status != 1) ou JSON inválido.
     */
    private function get(int $pacote, string $documento): array
    {
        $path = rawurlencode($this->token).'/'.$pacote.'/'.rawurlencode($documento);
        $body = (string) $this->http->request('GET', $path)->getBody();

        /** @var array<string, mixed>|null $json */
        $json = json_decode($body, true);
        if (! is_array($json)) {
            throw NfseApiException::requestError('Resposta inválida da API cpfcnpj.com.br.');
        }
        if (($json['status'] ?? 0) !== 1) {
            $msg = isset($json['erro']) ? (string) $json['erro'] : 'Consulta cpfcnpj.com.br sem sucesso.';
            throw NfseApiException::requestError($msg, (int) ($json['erroCodigo'] ?? 0));
        }

        return $json;
    }
}
