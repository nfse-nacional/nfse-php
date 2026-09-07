<?php

use Nfse\Support\SchemaText;

it('converts a typographic apostrophe to a straight one', function () {
    expect(SchemaText::forSchema("Rua D\u{2019}Oeste"))->toBe("Rua D'Oeste");
});

it('drops characters outside the Latin-1 range', function () {
    expect(SchemaText::forSchema("A\u{20AC}B\u{1F600}C"))->toBe('ABC');
});

it('replaces a non-breaking space with a regular space', function () {
    expect(SchemaText::forSchema("Rua\u{00A0}X"))->toBe('Rua X');
});

it('recomposes decomposed accents (NFD)', function () {
    expect(SchemaText::forSchema("Jose\u{0301}"))->toBe('José');
})->skip(! class_exists(\Normalizer::class), 'ext-intl not installed');

it('trims and collapses whitespace', function () {
    expect(SchemaText::forSchema('  Rua   X  '))->toBe('Rua X');
});

it('leaves valid Latin-1 text unchanged', function () {
    $value = 'Avenida Getúlio Vargas, 1.200 - Térreo';

    expect(SchemaText::forSchema($value))->toBe($value);
});

it('keeps null as null', function () {
    expect(SchemaText::forSchema(null))->toBeNull();
});
