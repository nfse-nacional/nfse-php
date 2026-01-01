<?php

use Nfse\Dto\Nfse\CancelamentoData;
use Nfse\Dto\Nfse\InfPedRegData;
use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Xml\EventosXmlBuilder;

it('includes both CNPJAutor and CPFAutor if both are provided', function () {
    $ch = '12345678901234567890123456789012345678901234567890';
    $cancel = new CancelamentoData(descricao: 'x', codigoMotivo: '1', motivo: 'm');

    $inf = new InfPedRegData(
        tipoAmbiente: 2,
        versaoAplicativo: '1.0',
        dataHoraEvento: '2025-01-01T12:00:00-03:00',
        chaveNfse: $ch,
        cnpjAutor: '12345678000199',
        cpfAutor: '11122233344',
        nPedRegEvento: 5,
        e101101: $cancel
    );

    $pedido = new PedRegEventoData(infPedReg: $inf);
    $xml = (new EventosXmlBuilder)->buildPedRegEvento($pedido);

    expect($xml)->toContain('<CNPJAutor>12345678000199</CNPJAutor>');
    expect($xml)->toContain('<CPFAutor>11122233344</CPFAutor>');
});
