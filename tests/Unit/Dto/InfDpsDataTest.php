<?php

namespace Nfse\Tests\Unit\Dto;

use Nfse\Nfse\Dto\InfDpsData;

it('can instantiate inf dps data', function () {
    $infDps = new InfDpsData(
        id: 'DPS123',
        tipoAmbiente: 2,
        dataEmissao: '2023-10-27T10:00:00',
        versaoAplicativo: '1.0',
        serie: '1',
        numeroDps: '1001',
        dataCompetencia: '2023-10-27',
        tipoEmitente: 1,
        codigoLocalEmissao: '3550308',
        motivoEmissaoTomadorIntermediario: null,
        chaveNfseRejeitada: null,
        substituicao: null,
        prestador: null,
        tomador: null,
        intermediario: null,
        servico: null,
        valores: null
    );

    expect($infDps)->toBeInstanceOf(InfDpsData::class)
        ->and($infDps->id)->toBe('DPS123');
});
