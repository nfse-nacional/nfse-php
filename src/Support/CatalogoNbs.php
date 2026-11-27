<?php

namespace Nfse\Support;

/**
 * Códigos NBS 2.0 de quatro níveis (9 dígitos), extraídos do Anexo B.
 */
final class CatalogoNbs
{
    /** @var array<string, true>|null */
    private static ?array $codigos = null;

    public static function contem(string $codigo): bool
    {
        $codigo = preg_replace('/\D/', '', $codigo) ?? '';

        return isset(self::codigos()[$codigo]);
    }

    /**
     * @return array<string, true>
     */
    private static function codigos(): array
    {
        if (self::$codigos !== null) {
            return self::$codigos;
        }

        $arquivo = dirname(__DIR__, 2).'/references/nbs2.json';
        $conteudo = file_get_contents($arquivo);
        $lista = json_decode($conteudo === false ? '[]' : $conteudo, true);
        self::$codigos = [];

        if (! is_array($lista)) {
            return self::$codigos;
        }

        foreach ($lista as $item) {
            if (is_array($item) && isset($item['codigo'])) {
                self::$codigos[(string) $item['codigo']] = true;
            }
        }

        return self::$codigos;
    }
}
