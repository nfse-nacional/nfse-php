<?php

namespace Nfse\Tests\Unit\Enums;

use Nfse\Enums\CodigoStatus;
use Nfse\Enums\EmitenteDPS;
use Nfse\Enums\MovimentacaoTemporariaBens;
use Nfse\Enums\ProcessoEmissao;
use Nfse\Enums\RegimeEspecialTributacao;
use Nfse\Enums\TipoAjusteBaseCalculo;
use Nfse\Enums\TipoAmbiente;
use Nfse\Enums\TipoCobrancaCondominio;
use Nfse\Enums\TipoDescontoCondominio;
use Nfse\Enums\TipoDetalhamentoCobrancaCondominio;

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
        expect(MovimentacaoTemporariaBens::Desconhecido->value)->toBe('0')
            ->and(MovimentacaoTemporariaBens::Nao->value)->toBe('1')
            ->and(MovimentacaoTemporariaBens::DeclaracaoImportacao->value)->toBe('2')
            ->and(MovimentacaoTemporariaBens::DeclaracaoExportacao->value)->toBe('3');
    });

    it('can create from value', function () {
        expect(MovimentacaoTemporariaBens::from('0'))->toBe(MovimentacaoTemporariaBens::Desconhecido)
            ->and(MovimentacaoTemporariaBens::from('1'))->toBe(MovimentacaoTemporariaBens::Nao)
            ->and(MovimentacaoTemporariaBens::from('2'))->toBe(MovimentacaoTemporariaBens::DeclaracaoImportacao)
            ->and(MovimentacaoTemporariaBens::from('3'))->toBe(MovimentacaoTemporariaBens::DeclaracaoExportacao);

        expect(MovimentacaoTemporariaBens::tryFrom('0'))->toBe(MovimentacaoTemporariaBens::Desconhecido)
            ->and(MovimentacaoTemporariaBens::tryFrom('99'))->toBeNull();
    });

    it('returns all cases', function () {
        $cases = MovimentacaoTemporariaBens::cases();

        expect($cases)->toHaveCount(4)
            ->and($cases[0])->toBe(MovimentacaoTemporariaBens::Desconhecido)
            ->and($cases[1])->toBe(MovimentacaoTemporariaBens::Nao)
            ->and($cases[2])->toBe(MovimentacaoTemporariaBens::DeclaracaoImportacao)
            ->and($cases[3])->toBe(MovimentacaoTemporariaBens::DeclaracaoExportacao);
    });

    it('returns correct descriptions', function () {
        expect(MovimentacaoTemporariaBens::Desconhecido->getDescription())->toBe('Desconhecido (tipo não informado na nota de origem)')
            ->and(MovimentacaoTemporariaBens::Nao->getDescription())->toBe('Não')
            ->and(MovimentacaoTemporariaBens::DeclaracaoImportacao->getDescription())->toBe('Vinculada - Declaração de Importação')
            ->and(MovimentacaoTemporariaBens::DeclaracaoExportacao->getDescription())->toBe('Vinculada - Declaração de Exportação');

        expect(MovimentacaoTemporariaBens::Desconhecido->label())->toBe('Desconhecido (tipo não informado na nota de origem)')
            ->and(MovimentacaoTemporariaBens::Nao->label())->toBe('Não');

    });
});

describe('TipoAjusteBaseCalculo', function () {
    it('has the values of TSRTCTpAjusteBC', function () {
        expect(TipoAjusteBaseCalculo::cases())->toHaveCount(13)
            ->and(TipoAjusteBaseCalculo::Materiais->value)->toBe('2')
            ->and(TipoAjusteBaseCalculo::RepasseConsorciado->value)->toBe('5')
            ->and(TipoAjusteBaseCalculo::OutrasDeducoes->value)->toBe('99')
            ->and(TipoAjusteBaseCalculo::RepasseIntermediacaoImoveis->value)->toBe('101')
            ->and(TipoAjusteBaseCalculo::OutrosReembolsos->value)->toBe('199')
            ->and(TipoAjusteBaseCalculo::tryFrom('1'))->toBeNull()
            ->and(TipoAjusteBaseCalculo::Materiais->label())->toBe('Materiais');
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

describe('TipoCobrancaCondominio', function () {
    it('has the values of TSRTCTpCobranca', function () {
        expect(TipoCobrancaCondominio::cases())->toHaveCount(6)
            ->and(TipoCobrancaCondominio::CondominioOrdinario->value)->toBe('01')
            ->and(TipoCobrancaCondominio::OutraCobranca->value)->toBe('99')
            ->and(TipoCobrancaCondominio::tryFrom('00'))->toBeNull()
            ->and(TipoCobrancaCondominio::CondominioOrdinario->label())->toBe('Condomínio Ordinário');
    });
});

describe('TipoDescontoCondominio', function () {
    it('has the values of TSRTCTpDesconto', function () {
        expect(TipoDescontoCondominio::cases())->toHaveCount(2)
            ->and(TipoDescontoCondominio::DescontoIncondicionado->value)->toBe('1')
            ->and(TipoDescontoCondominio::DescontoCondicionado->value)->toBe('2')
            ->and(TipoDescontoCondominio::tryFrom('3'))->toBeNull()
            ->and(TipoDescontoCondominio::DescontoCondicionado->label())->toBe('Desconto Condicionado');
    });
});

describe('TipoDetalhamentoCobrancaCondominio', function () {
    it('has the values of TSRTCTpDetCobranca', function () {
        expect(TipoDetalhamentoCobrancaCondominio::cases())->toHaveCount(37)
            ->and(TipoDetalhamentoCobrancaCondominio::CondominioComumCrd->value)->toBe('001')
            ->and(TipoDetalhamentoCobrancaCondominio::CondominioIrrecuperavel->value)->toBe('036')
            ->and(TipoDetalhamentoCobrancaCondominio::Outro->value)->toBe('999')
            ->and(TipoDetalhamentoCobrancaCondominio::tryFrom('000'))->toBeNull()
            ->and(TipoDetalhamentoCobrancaCondominio::Outro->label())->toBe('Outro');
    });
});
