<?php

namespace Nfse\Tests\Unit\Xml;

use InvalidArgumentException;
use Nfse\Enums\TipoAmbiente;
use Nfse\Xml\SchemaDps;

it('aponta producao para o schema atual e homologacao para o pacote 20261124', function () {
    expect(SchemaDps::padrao(TipoAmbiente::Producao))->toBe(SchemaDps::Producao)
        ->and(SchemaDps::Producao->value)->toBe('20261020')
        ->and(SchemaDps::padrao(TipoAmbiente::Homologacao))->toBe(SchemaDps::Homologacao)
        ->and(SchemaDps::Homologacao->value)->toBe('20261124');
});

it('resolve a versao informada e recusa schema desconhecido', function () {
    expect(SchemaDps::resolver('20261020'))->toBe(SchemaDps::Producao)
        ->and(SchemaDps::resolver('20261124', TipoAmbiente::Producao))->toBe(SchemaDps::Homologacao)
        ->and(SchemaDps::resolver(null, TipoAmbiente::Homologacao))->toBe(SchemaDps::Homologacao);

    expect(fn () => SchemaDps::resolver('19990101'))
        ->toThrow(InvalidArgumentException::class, 'Schema não encontrado: 19990101');
});

it('aponta a pasta de cada pacote que permanece no projeto', function () {
    expect(is_dir(SchemaDps::Producao->pasta()))->toBeTrue()
        ->and(str_ends_with(SchemaDps::Producao->pasta(), '/references/schemas/20261020'))->toBeTrue()
        ->and(is_dir(SchemaDps::Homologacao->pasta()))->toBeTrue()
        ->and(str_ends_with(SchemaDps::Homologacao->pasta(), '/references/schemas/20261124'))->toBeTrue()
        ->and(is_file(SchemaDps::Producao->pasta().'/DPS_v1.01.xsd'))->toBeTrue()
        ->and(is_file(SchemaDps::Homologacao->pasta().'/DPS_v1.01.xsd'))->toBeTrue();
});
