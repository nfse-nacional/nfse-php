<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\NfseData;
use Nfse\Xml\NfseXmlParser;

it('can parse full nfse xml from fixture', function () {
    $xmlContent = file_get_contents(__DIR__.'/../../fixtures/nfse.xml');

    $parser = new NfseXmlParser;
    $nfseData = $parser->parse($xmlContent);

    expect($nfseData)->toBeInstanceOf(NfseData::class)
        ->and($nfseData->versao)->toBe('1.00')
        // InfNfse
        ->and($nfseData->infNfse->id)->toBe('NFS15054862231305199000190000000000000225121645026250')
        ->and($nfseData->infNfse->numeroNfse)->toBe('2')
        ->and($nfseData->infNfse->numeroDfse)->toBe('9')
        ->and($nfseData->infNfse->dataProcessamento)->toBe('2025-12-03T09:51:59-03:00')
        ->and($nfseData->infNfse->codigoVerificacao)->toBeNull() // Not present in XML
        ->and($nfseData->infNfse->ambienteGerador)->toBe(\Nfse\Enums\AmbienteGerador::SefinNacional) // 2
        ->and($nfseData->infNfse->tipoEmissao)->toBe(1) // 1
        ->and($nfseData->infNfse->processoEmissao)->toBe(\Nfse\Enums\ProcessoEmissao::WebFisco) // 2

        // Emitente
        ->and($nfseData->infNfse->emitente->cnpj)->toBe('31305199000190')
        ->and($nfseData->infNfse->emitente->nome)->toBe('DINAMARQUES T SANTOS')
        ->and($nfseData->infNfse->emitente->inscricaoMunicipal)->toBe('2348')
        ->and($nfseData->infNfse->emitente->endereco->logradouro)->toBe('RUA INÊS SOARES')
        ->and($nfseData->infNfse->emitente->endereco->numero)->toBe('0')
        ->and($nfseData->infNfse->emitente->endereco->bairro)->toBe('CENTRO')
        ->and($nfseData->infNfse->emitente->endereco->codigoMunicipio)->toBe('1505486')
        ->and($nfseData->infNfse->emitente->endereco->uf)->toBe('PA')
        ->and($nfseData->infNfse->emitente->endereco->cep)->toBe('68485000')

        // DPS
        ->and($nfseData->infNfse->dps->versao)->toBe('1.00')
        ->and($nfseData->infNfse->dps->infDps->id)->toBe('DPS150548623130519900019000900000000000000003')
        ->and($nfseData->infNfse->dps->infDps->numeroDps)->toBe('3')
        ->and($nfseData->infNfse->dps->infDps->serie)->toBe('900')
        ->and($nfseData->infNfse->dps->infDps->dataEmissao)->toBe('2025-12-03T09:51:58-03:00')
        ->and($nfseData->infNfse->dps->infDps->tipoAmbiente)->toBe(\Nfse\Enums\TipoAmbiente::Homologacao)
        ->and($nfseData->infNfse->dps->infDps->prestador->cnpj)->toBe('31305199000190')
        ->and($nfseData->infNfse->dps->infDps->tomador->cpf)->toBe('76920500230')
        ->and($nfseData->infNfse->dps->infDps->tomador->nome)->toBe('FRANCIONE DA ROCHA NASCIMENTO')

        // Servico
        ->and($nfseData->infNfse->dps->infDps->servico->codigoServico->descricaoServico)->toBe('ultrassonografia')
        ->and($nfseData->infNfse->dps->infDps->servico->codigoServico->codigoTributacaoNacional)->toBe('040303')
        ->and($nfseData->infNfse->dps->infDps->servico->codigoServico->codigoNbs)->toBe('123012100')

        // Valores
        ->and($nfseData->infNfse->dps->infDps->valores->valorServicoPrestado->valorServico)->toBe(230.00)
        ->and($nfseData->infNfse->dps->infDps->valores->tributacao->tributacaoIssqn)->toBe(\Nfse\Enums\TributacaoIssqn::OperacaoTributavel) // 1
        ->and($nfseData->infNfse->dps->infDps->valores->tributacao->tipoRetencaoIssqn)->toBe(\Nfse\Enums\TipoRetencaoIssqn::NaoRetido) // 1
        ->and($nfseData->infNfse->dps->infDps->valores->tributacao->percentualTotalTributosSN)->toBe(5.00);
});
