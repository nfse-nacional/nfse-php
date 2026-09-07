<?php

namespace Nfse\Support;

class SchemaText
{
    /**
     * Ajusta um texto ao charset aceito pelos campos TSString do layout
     * (xLgr, xCpl, xBairro, xNome, ...). O TSString restringe cada caractere a
     * U+0020–U+00FF (Latin-1 imprimível) e não admite espaço nas extremidades;
     * valores com apóstrofo tipográfico (U+2019), acento decomposto (NFD) ou
     * espaço fixo (U+00A0) são recusados pela SEFIN com o erro E1235.
     *
     * A limpeza é conservadora: valores já válidos (dígitos, datas, textos em
     * Latin-1) não mudam.
     *
     * @param  string|null  $value  Valor original.
     * @return string|null Valor compatível com o schema (ou null se entrou null).
     */
    public static function forSchema(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (class_exists(\Normalizer::class)) {
            $normalized = \Normalizer::normalize($value, \Normalizer::FORM_C);
            if ($normalized !== false) {
                $value = $normalized;
            }
        }

        $value = strtr($value, [
            "\u{2018}" => "'",
            "\u{2019}" => "'",
            "\u{201A}" => "'",
            "\u{201B}" => "'",
            "\u{201C}" => '"',
            "\u{201D}" => '"',
            "\u{2013}" => '-',
            "\u{2014}" => '-',
            "\u{2026}" => '...',
            "\u{00A0}" => ' ',
        ]);

        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value) ?? $value;
        $value = preg_replace('/[^\x{0020}-\x{00FF}]/u', '', $value) ?? $value;
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;

        return trim($value);
    }
}
