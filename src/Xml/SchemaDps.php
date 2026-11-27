<?php

namespace Nfse\Xml;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use Nfse\Enums\TipoAmbiente;

/**
 * Pacote de esquemas da DPS. A lista de lançamentos escolhe a versão.
 * Sem versão na chamada, a lista do ambiente escolhe o pacote pela data.
 */
final class SchemaDps
{
    /**
     * Data de lançamento e versão do pacote. A chave é o valor de TipoAmbiente.
     *
     * @var array<string, list<array{0: string, 1: string}>>
     */
    private const LANCAMENTOS = [
        '1' => [
            ['09/02/2026', '20260209'],
            ['07/12/2026', '20261124'],
        ],
        '2' => [
            ['20/10/2026', '20261020'],
            ['24/11/2026', '20261124'],
        ],
    ];

    public static function padrao(mixed $ambiente, ?DateTimeInterface $data = null): string
    {
        $dia = ($data ?? new DateTimeImmutable('today', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d');
        $chave = $ambiente instanceof TipoAmbiente ? $ambiente->value : (string) $ambiente;
        $lancamentos = self::LANCAMENTOS[$chave] ?? null;
        if ($lancamentos === null) {
            throw new InvalidArgumentException('Ambiente não encontrado: '.$chave);
        }

        $versao = null;
        foreach ($lancamentos as [$lancamento, $pacote]) {
            $dataLancamento = DateTimeImmutable::createFromFormat('!d/m/Y', $lancamento);
            if ($dataLancamento !== false && $dataLancamento->format('Y-m-d') <= $dia) {
                $versao = $pacote;
            }
        }

        if ($versao === null) {
            throw new InvalidArgumentException('Schema não encontrado: '.$chave);
        }

        return $versao;
    }

    public static function resolver(?string $schema, mixed $ambiente = null, ?DateTimeInterface $data = null): string
    {
        if ($schema === null || $schema === '') {
            return self::padrao($ambiente, $data);
        }

        if (! self::conhecida($schema)) {
            throw new InvalidArgumentException('Schema não encontrado: '.$schema);
        }

        return $schema;
    }

    public static function pasta(string $versao): string
    {
        if (! self::conhecida($versao)) {
            throw new InvalidArgumentException('Schema não encontrado: '.$versao);
        }

        $pasta = dirname(__DIR__, 2).'/references/schemas/'.$versao;
        if (! is_dir($pasta)) {
            throw new InvalidArgumentException('Schema não encontrado: '.$versao);
        }

        return $pasta;
    }

    private static function conhecida(string $versao): bool
    {
        foreach (self::LANCAMENTOS as $lista) {
            foreach ($lista as [, $pacote]) {
                if ($pacote === $versao) {
                    return true;
                }
            }
        }

        return false;
    }
}
