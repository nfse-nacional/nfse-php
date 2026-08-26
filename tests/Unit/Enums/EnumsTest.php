<?php

namespace Nfse\Tests\Unit\Enums;

use Nfse\Enums\CodigoStatus;
use Nfse\Enums\EmitenteDPS;
use Nfse\Enums\MovimentacaoTemporariaBens;
use Nfse\Enums\ProcessoEmissao;
use Nfse\Enums\RegimeEspecialTributacao;
use Nfse\Enums\TipoAmbiente;
use Nfse\Enums\TipoDeducaoReducao;

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

describe('TipoNsu', function () {
    it('has correct values', function () {
        expect(\Nfse\Enums\TipoNsu::Recepcao->value)->toBe('RECEPCAO')
            ->and(\Nfse\Enums\TipoNsu::Distribuicao->value)->toBe('DISTRIBUICAO')
            ->and(\Nfse\Enums\TipoNsu::Geral->value)->toBe('GERAL')
            ->and(\Nfse\Enums\TipoNsu::Mei->value)->toBe('MEI');
    });

    it('returns correct descriptions', function () {
        expect(\Nfse\Enums\TipoNsu::Recepcao->getDescription())->toBe('Recepção')
            ->and(\Nfse\Enums\TipoNsu::Geral->label())->toBe('Geral');
    });
});

describe('TributacaoIssqn', function () {
    it('has correct values', function () {
        expect(\Nfse\Enums\TributacaoIssqn::OperacaoTributavel->value)->toBe(1)
            ->and(\Nfse\Enums\TributacaoIssqn::Imunidade->value)->toBe(2);
    });
});

describe('TipoRetencaoIssqn', function () {
    it('has correct values', function () {
        expect(\Nfse\Enums\TipoRetencaoIssqn::NaoRetido->value)->toBe(1)
            ->and(\Nfse\Enums\TipoRetencaoIssqn::RetidoTomador->value)->toBe(2);
    });
});

describe('TipoImunidade', function () {
    it('has correct values', function () {
        expect(\Nfse\Enums\TipoImunidade::NaoInformado->value)->toBe(0)
            ->and(\Nfse\Enums\TipoImunidade::PatrimonioRendaServicos->value)->toBe(1);
    });
});

describe('TipoSuspensao', function () {
    it('has correct values', function () {
        expect(\Nfse\Enums\TipoSuspensao::DecisaoJudicial->value)->toBe(1)
            ->and(\Nfse\Enums\TipoSuspensao::DecisaoAdministrativa->value)->toBe(2);
    });
});

describe('TipoRetencaoPisCofins', function () {
    it('has correct values', function () {
        expect(\Nfse\Enums\TipoRetencaoPisCofins::PisCofinsNaoRetido->value)->toBe(2)
            ->and(\Nfse\Enums\TipoRetencaoPisCofins::PisCofinsRetido->value)->toBe(1)
            ->and(\Nfse\Enums\TipoRetencaoPisCofins::NaoRetidos->value)->toBe(0);
    });
});

describe('IndicadorTotalTributos', function () {
    it('has correct values', function () {
        expect(\Nfse\Enums\IndicadorTotalTributos::Nenhum->value)->toBe(0)
            ->and(\Nfse\Enums\IndicadorTotalTributos::Lei12741->value)->toBe(1);
    });
});

describe('MovimentacaoTemporariaBens', function () {
    it('has correct values', function () {
        expect(MovimentacaoTemporariaBens::Nenhum->value)->toBe('0')
            ->and(MovimentacaoTemporariaBens::Nao->value)->toBe('1')
            ->and(MovimentacaoTemporariaBens::SimImportacao->value)->toBe('2')
            ->and(MovimentacaoTemporariaBens::SimExportacao->value)->toBe('3');
    });

    it('can create from value', function () {
        expect(MovimentacaoTemporariaBens::from('0'))->toBe(MovimentacaoTemporariaBens::Nenhum)
            ->and(MovimentacaoTemporariaBens::from('1'))->toBe(MovimentacaoTemporariaBens::Nao)
            ->and(MovimentacaoTemporariaBens::from('2'))->toBe(MovimentacaoTemporariaBens::SimImportacao)
            ->and(MovimentacaoTemporariaBens::from('3'))->toBe(MovimentacaoTemporariaBens::SimExportacao);

        expect(MovimentacaoTemporariaBens::tryFrom('0'))->toBe(MovimentacaoTemporariaBens::Nenhum)
            ->and(MovimentacaoTemporariaBens::tryFrom('99'))->toBeNull();
    });

    it('returns all cases', function () {
        $cases = MovimentacaoTemporariaBens::cases();

        expect($cases)->toHaveCount(4)
            ->and($cases[0])->toBe(MovimentacaoTemporariaBens::Nenhum)
            ->and($cases[1])->toBe(MovimentacaoTemporariaBens::Nao)
            ->and($cases[2])->toBe(MovimentacaoTemporariaBens::SimImportacao)
            ->and($cases[3])->toBe(MovimentacaoTemporariaBens::SimExportacao);
    });

    it('returns correct descriptions', function () {
        expect(MovimentacaoTemporariaBens::Nenhum->getDescription())->toBe('Nenhum')
            ->and(MovimentacaoTemporariaBens::Nao->getDescription())->toBe('Não')
            ->and(MovimentacaoTemporariaBens::SimImportacao->getDescription())->toBe('Sim (Importação)')
            ->and(MovimentacaoTemporariaBens::SimExportacao->getDescription())->toBe('Sim (Exportação)');

        expect(MovimentacaoTemporariaBens::Nenhum->label())->toBe('Nenhum')
            ->and(MovimentacaoTemporariaBens::Nao->label())->toBe('Não');

    });
});

describe('TipoDeducaoReducao', function () {
    it('has all values of TSIdeDedRed from schema 1.01', function () {
        expect(TipoDeducaoReducao::cases())->toHaveCount(10)
            ->and(TipoDeducaoReducao::AlimentacaoBebidas->value)->toBe('1')
            ->and(TipoDeducaoReducao::Materiais->value)->toBe('2')
            ->and(TipoDeducaoReducao::ProducaoExterna->value)->toBe('3')
            ->and(TipoDeducaoReducao::ReembolsoDespesas->value)->toBe('4')
            ->and(TipoDeducaoReducao::RepasseConsorciado->value)->toBe('5')
            ->and(TipoDeducaoReducao::RepassePlanoSaude->value)->toBe('6')
            ->and(TipoDeducaoReducao::Servicos->value)->toBe('7')
            ->and(TipoDeducaoReducao::SubempreitadaMaoObra->value)->toBe('8')
            ->and(TipoDeducaoReducao::ProfissionalParceiro->value)->toBe('9')
            ->and(TipoDeducaoReducao::OutrasDeducoes->value)->toBe('99');
    });

    it('can create from value', function () {
        expect(TipoDeducaoReducao::from('3'))->toBe(TipoDeducaoReducao::ProducaoExterna)
            ->and(TipoDeducaoReducao::tryFrom('4'))->toBe(TipoDeducaoReducao::ReembolsoDespesas)
            ->and(TipoDeducaoReducao::tryFrom('10'))->toBeNull();
    });

    it('returns correct descriptions', function () {
        expect(TipoDeducaoReducao::AlimentacaoBebidas->getDescription())->toBe('Alimentação e bebidas/frigobar')
            ->and(TipoDeducaoReducao::SubempreitadaMaoObra->getDescription())->toBe('Subempreitada de mão de obra')
            ->and(TipoDeducaoReducao::ProfissionalParceiro->getDescription())->toBe('Profissional parceiro')
            ->and(TipoDeducaoReducao::OutrasDeducoes->label())->toBe('Outras deduções');
    });
});

describe('CodigoStatus', function () {
    it('has only the values of TStat from schema 1.01', function () {
        expect(CodigoStatus::cases())->toHaveCount(4)
            ->and(CodigoStatus::NfseGerada->value)->toBe(100)
            ->and(CodigoStatus::NfseDecisaoJudicial->value)->toBe(102)
            ->and(CodigoStatus::NfseAvulsa->value)->toBe(103)
            ->and(CodigoStatus::NfseMei->value)->toBe(107)
            ->and(CodigoStatus::tryFrom(101))->toBeNull();
    });
});

describe('RegimeEspecialTributacao', function () {
    it('has only the values of TSRegEspTrib from schema 1.01', function () {
        expect(RegimeEspecialTributacao::cases())->toHaveCount(8)
            ->and(RegimeEspecialTributacao::Nenhum->value)->toBe('0')
            ->and(RegimeEspecialTributacao::AtoCooperado->value)->toBe('1')
            ->and(RegimeEspecialTributacao::Estimativa->value)->toBe('2')
            ->and(RegimeEspecialTributacao::MicroempresaMunicipal->value)->toBe('3')
            ->and(RegimeEspecialTributacao::NotarioOuRegistrador->value)->toBe('4')
            ->and(RegimeEspecialTributacao::ProfissionalAutonomo->value)->toBe('5')
            ->and(RegimeEspecialTributacao::SociedadeDeProfissionais->value)->toBe('6')
            ->and(RegimeEspecialTributacao::Outros->value)->toBe('9')
            ->and(RegimeEspecialTributacao::Outros->getDescription())->toBe('Outros')
            ->and(RegimeEspecialTributacao::tryFrom('7'))->toBeNull()
            ->and(RegimeEspecialTributacao::tryFrom('8'))->toBeNull()
            ->and(RegimeEspecialTributacao::tryFrom('10'))->toBeNull();
    });
});
