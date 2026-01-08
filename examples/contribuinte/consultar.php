<?php

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__.'/../bootstrap.php';

try {
    $chave = '23044002257302627000114000000000000324114302061222'; // Substitua pela chave real

    echo "Consultando NFS-e: $chave...\n";

    $nfseData = $nfse->contribuinte()->consultar($chave);

    if ($nfseData) {
        echo "NFS-e encontrada!\n\n";

        // Show service description to verify encoding is fixed
        $descricao = $nfseData->infNfse->dps->infDps->servico->codigoServico->descricaoServico;
        echo 'Descrição do serviço: '.$descricao."\n";

        // Build XML
        $xmlBuilder = new \Nfse\Xml\NfseXmlBuilder;
        $xml = $xmlBuilder->build($nfseData);

        // Check if the XML has correct encoding
        if (str_contains($xml, 'Descrição do Serviço')) {
            echo "✓ XML com encoding correto!\n\n";
        } else {
            echo "✗ XML com encoding incorreto!\n\n";
        }

        // Optionally show a snippet of the XML
        preg_match('/<xDescServ>(.*?)<\/xDescServ>/', $xml, $matches);
        if (isset($matches[1])) {
            echo 'xDescServ no XML: '.$matches[1]."\n";
        }
    } else {
        echo "NFS-e não encontrada.\n";
    }
} catch (\Exception $e) {
    echo 'Erro: '.$e->getMessage()."\n";
}
