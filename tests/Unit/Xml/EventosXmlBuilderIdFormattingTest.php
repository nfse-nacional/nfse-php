<?php

use Nfse\Dto\Nfse\CancelamentoData;
use Nfse\Dto\Nfse\InfPedRegData;
use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Xml\EventosXmlBuilder;

it('constructs Id with zero padded nPedRegEvento and preserves large numbers', function () {
    $ch = str_repeat('9', 50);
    $cancel = new CancelamentoData(descricao: 'x', codigoMotivo: '1', motivo: 'm');

    $inf = new InfPedRegData(
        tipoAmbiente: 2,
        versaoAplicativo: '1.0',
        dataHoraEvento: '2025-01-01T12:00:00-03:00',
        chaveNfse: $ch,
        nPedRegEvento: 123
    );

    $inf->e101101 = $cancel;

    $pedido = new PedRegEventoData(infPedReg: $inf);
    $xml = (new EventosXmlBuilder)->buildPedRegEvento($pedido);

    expect($xml)->toContain('nPedRegEvento>123</nPedRegEvento>');
    expect($xml)->toContain('Id="PRE'.$ch.'101101123');
});
