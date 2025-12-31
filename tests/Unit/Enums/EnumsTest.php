<?php

namespace Nfse\Tests\Unit\Enums;

use Nfse\Enums\TipoAmbiente;
use Nfse\Enums\EmitenteDPS;
use Nfse\Enums\ProcessoEmissao;

describe('TipoAmbiente', function () {
    it('has correct values', function () {
        expect(TipoAmbiente::Producao->value)->toBe('1')
            ->and(TipoAmbiente::Homologacao->value)->toBe('2');
    });

    it('can create from value', function () {
        expect(TipoAmbiente::from('1'))->toBe(TipoAmbiente::Producao)
            ->and(TipoAmbiente::from('2'))->toBe(TipoAmbiente::Homologacao);
        
        expect(TipoAmbiente::tryFrom('1'))->toBe(TipoAmbiente::Producao)
            ->and(TipoAmbiente::tryFrom('99'))->toBeNull();
    });

    it('returns all cases', function () {
        $cases = TipoAmbiente::cases();
        
        expect($cases)->toHaveCount(2)
            ->and($cases[0])->toBe(TipoAmbiente::Producao)
            ->and($cases[1])->toBe(TipoAmbiente::Homologacao);
    });

    it('returns correct descriptions', function () {
        expect(TipoAmbiente::Producao->getDescription())->toBe('Produção')
            ->and(TipoAmbiente::Homologacao->getDescription())->toBe('Homologação')
            ->and(TipoAmbiente::Producao->label())->toBe('Produção');
    });
});

describe('EmitenteDPS', function () {
    it('has correct values', function () {
        expect(EmitenteDPS::Prestador->value)->toBe('1')
            ->and(EmitenteDPS::Tomador->value)->toBe('2')
            ->and(EmitenteDPS::Intermediario->value)->toBe('3');
    });

    it('can create from value', function () {
        expect(EmitenteDPS::from('1'))->toBe(EmitenteDPS::Prestador)
            ->and(EmitenteDPS::from('2'))->toBe(EmitenteDPS::Tomador)
            ->and(EmitenteDPS::from('3'))->toBe(EmitenteDPS::Intermediario);
        
        expect(EmitenteDPS::tryFrom('1'))->toBe(EmitenteDPS::Prestador)
            ->and(EmitenteDPS::tryFrom('99'))->toBeNull();
    });

    it('returns all cases', function () {
        $cases = EmitenteDPS::cases();
        
        expect($cases)->toHaveCount(3)
            ->and($cases[0])->toBe(EmitenteDPS::Prestador)
            ->and($cases[1])->toBe(EmitenteDPS::Tomador)
            ->and($cases[2])->toBe(EmitenteDPS::Intermediario);
    });

    it('returns correct descriptions', function () {
        expect(EmitenteDPS::Prestador->getDescription())->toBe('Prestador')
            ->and(EmitenteDPS::Tomador->getDescription())->toBe('Tomador')
            ->and(EmitenteDPS::Intermediario->getDescription())->toBe('Intermediário')
            ->and(EmitenteDPS::Prestador->label())->toBe('Prestador');
    });
});

describe('ProcessoEmissao', function () {
    it('has correct values', function () {
        expect(ProcessoEmissao::WebService->value)->toBe('1')
            ->and(ProcessoEmissao::WebFisco->value)->toBe('2')
            ->and(ProcessoEmissao::AppFisco->value)->toBe('3');
    });

    it('can create from value', function () {
        expect(ProcessoEmissao::from('1'))->toBe(ProcessoEmissao::WebService)
            ->and(ProcessoEmissao::from('2'))->toBe(ProcessoEmissao::WebFisco)
            ->and(ProcessoEmissao::from('3'))->toBe(ProcessoEmissao::AppFisco);
        
        expect(ProcessoEmissao::tryFrom('1'))->toBe(ProcessoEmissao::WebService)
            ->and(ProcessoEmissao::tryFrom('99'))->toBeNull();
    });

    it('returns all cases', function () {
        $cases = ProcessoEmissao::cases();
        
        expect($cases)->toHaveCount(3)
            ->and($cases[0])->toBe(ProcessoEmissao::WebService)
            ->and($cases[1])->toBe(ProcessoEmissao::WebFisco)
            ->and($cases[2])->toBe(ProcessoEmissao::AppFisco);
    });

    it('returns correct descriptions', function () {
        expect(ProcessoEmissao::WebService->getDescription())
            ->toBe('Emissão com aplicativo do contribuinte (via Web Service)');
        expect(ProcessoEmissao::WebFisco->getDescription())
            ->toBe('Emissão com aplicativo disponibilizado pelo fisco (Web)');
        expect(ProcessoEmissao::AppFisco->getDescription())
            ->toBe('Emissão com aplicativo disponibilizado pelo fisco (App)');
        expect(ProcessoEmissao::WebService->label())
            ->toBe('Emissão com aplicativo do contribuinte (via Web Service)');
    });
});
