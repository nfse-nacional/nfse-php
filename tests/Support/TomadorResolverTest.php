<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Support\Contracts\PessoaLookup;
use Nfse\Support\CpfCnpjComBrLookup;
use Nfse\Support\TomadorResolver;

it('monta um TomadorData PJ a partir do CNPJ', function () {
    $lookup = new class implements PessoaLookup
    {
        public function consultarCpf(string $cpf): array
        {
            return [];
        }

        public function consultarCnpj(string $cnpj): array
        {
            return [
                'nome' => 'TOKEN TEST LTDA',
                'logradouro' => 'Rua A',
                'numero' => '1',
                'complemento' => 'Sala 1',
                'bairro' => 'Centro',
                'cep' => '39400-000',
                'codigoMunicipioIbge' => 3143302,
            ];
        }
    };

    $tomador = (new TomadorResolver($lookup))->porCnpj('11.222.333/0001-81');

    expect($tomador)->toBeInstanceOf(TomadorData::class)
        ->and($tomador->cnpj)->toBe('11222333000181')
        ->and($tomador->nome)->toBe('TOKEN TEST LTDA')
        ->and($tomador->endereco->logradouro)->toBe('Rua A')
        ->and($tomador->endereco->codigoMunicipio)->toBe('3143302')
        ->and($tomador->endereco->cep)->toBe('39400000');
});

it('detecta CPF pelo tamanho e monta o TomadorData PF', function () {
    $lookup = new class implements PessoaLookup
    {
        public function consultarCpf(string $cpf): array
        {
            return [
                'nome' => 'Fulano de Tal',
                'logradouro' => 'Rua B',
                'cep' => '99999123',
                'codigoMunicipioIbge' => '1234567',
            ];
        }

        public function consultarCnpj(string $cnpj): array
        {
            return [];
        }
    };

    $tomador = (new TomadorResolver($lookup))->porDocumento('111.444.777-35');

    expect($tomador->cpf)->toBe('11144477735')
        ->and($tomador->cnpj)->toBeNull()
        ->and($tomador->nome)->toBe('Fulano de Tal')
        ->and($tomador->endereco->codigoMunicipio)->toBe('1234567');
});

it('normaliza a resposta de CNPJ da API cpfcnpj.com.br', function () {
    $payload = json_encode([
        'status' => 1,
        'cnpj' => '11.222.333/0001-81',
        'razao' => 'TOKEN TEST LTDA',
        'fantasia' => 'TOKEN TEST',
        'matrizEndereco' => ['logradouro' => 'Rua A', 'numero' => '1', 'bairro' => 'Centro', 'cep' => '0000-111'],
        'ibge' => ['cidade' => ['ibge_id' => 3143302]],
    ]);
    $http = new Client(['handler' => HandlerStack::create(new MockHandler([new Response(200, [], $payload)]))]);

    $dados = (new CpfCnpjComBrLookup('token', 3, 5, $http))->consultarCnpj('11222333000181');

    expect($dados['nome'])->toBe('TOKEN TEST LTDA')
        ->and($dados['logradouro'])->toBe('Rua A')
        ->and($dados['codigoMunicipioIbge'])->toBe(3143302);
});

it('lança NfseApiException quando a API responde status de erro', function () {
    $payload = json_encode(['status' => 0, 'erro' => 'CNPJ nao existe', 'erroCodigo' => 202]);
    $http = new Client(['handler' => HandlerStack::create(new MockHandler([new Response(200, [], $payload)]))]);

    (new CpfCnpjComBrLookup('token', 3, 5, $http))->consultarCnpj('11222333000181');
})->throws(NfseApiException::class);
