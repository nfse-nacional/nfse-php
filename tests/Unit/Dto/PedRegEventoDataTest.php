<?php

use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Dto\Nfse\InfPedRegData;

it('defaults versao to 1.01 when not provided', function () {
    $inf = new InfPedRegData(
        tipoAmbiente: 2,
        versaoAplicativo: '1.0',
        dataHoraEvento: '2025-01-01T12:00:00-03:00',
        chaveNfse: 'ABC'
    );

    $pedido = new PedRegEventoData(infPedReg: $inf);
    expect($pedido->versao)->toBe('1.01');
});
