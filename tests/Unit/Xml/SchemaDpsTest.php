<?php

namespace Nfse\Tests\Unit\Xml;

use DateTimeImmutable;
use InvalidArgumentException;
use Nfse\Enums\TipoAmbiente;
use Nfse\Xml\SchemaDps;

it('escolhe o pacote pela data de lancamento do ambiente', function () {
    expect(SchemaDps::padrao(TipoAmbiente::Homologacao, new DateTimeImmutable('2026-10-21')))->toBe('20261020')
        ->and(SchemaDps::padrao(TipoAmbiente::Homologacao, new DateTimeImmutable('2026-11-28')))->toBe('20261124')
        ->and(SchemaDps::padrao(TipoAmbiente::Producao, new DateTimeImmutable('2026-11-27')))->toBe('20260209')
        ->and(SchemaDps::padrao(TipoAmbiente::Producao, new DateTimeImmutable('2026-12-07')))->toBe('20261124')
        ->and(SchemaDps::padrao(1, new DateTimeImmutable('2026-11-27')))->toBe('20260209')
        ->and(SchemaDps::padrao(2, new DateTimeImmutable('2026-11-28')))->toBe('20261124');

    expect(fn () => SchemaDps::padrao(9, new DateTimeImmutable('2026-11-27')))
        ->toThrow(InvalidArgumentException::class, 'Ambiente não encontrado: 9');
});

it('resolve a versao informada e recusa schema desconhecido', function () {
    expect(SchemaDps::resolver('20261020'))->toBe('20261020')
        ->and(SchemaDps::resolver('20261124', TipoAmbiente::Producao, new DateTimeImmutable('2026-11-28')))->toBe('20261124')
        ->and(SchemaDps::resolver('20260209'))->toBe('20260209')
        ->and(SchemaDps::resolver(null, TipoAmbiente::Homologacao, new DateTimeImmutable('2026-10-21')))->toBe('20261020');

    expect(fn () => SchemaDps::resolver('19990101'))
        ->toThrow(InvalidArgumentException::class, 'Schema não encontrado: 19990101');
});

it('aponta a pasta de cada pacote que permanece no projeto', function () {
    expect(is_dir(SchemaDps::pasta('20260209')))->toBeTrue()
        ->and(str_ends_with(SchemaDps::pasta('20260209'), '/references/schemas/20260209'))->toBeTrue()
        ->and(is_dir(SchemaDps::pasta('20261020')))->toBeTrue()
        ->and(str_ends_with(SchemaDps::pasta('20261020'), '/references/schemas/20261020'))->toBeTrue()
        ->and(is_dir(SchemaDps::pasta('20261124')))->toBeTrue()
        ->and(str_ends_with(SchemaDps::pasta('20261124'), '/references/schemas/20261124'))->toBeTrue()
        ->and(is_file(SchemaDps::pasta('20260209').'/DPS_v1.01.xsd'))->toBeTrue()
        ->and(is_file(SchemaDps::pasta('20261020').'/DPS_v1.01.xsd'))->toBeTrue()
        ->and(is_file(SchemaDps::pasta('20261124').'/DPS_v1.01.xsd'))->toBeTrue();
});
