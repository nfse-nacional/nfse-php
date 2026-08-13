<?php

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__.'/../bootstrap.php';

try {
    $chave = '35503080000000000000000000000000000000000000'; // Substitua pela chave real

    echo "Consultando a NFS-e e gerando o DANFSe localmente: $chave...\n";

    $pdfContent = $nfse->contribuinte()->downloadDanfse($chave);

    $filename = __DIR__."/danfse_$chave.pdf";
    file_put_contents($filename, $pdfContent);

    echo "DANFSe salvo em: $filename\n";
} catch (\Exception $e) {
    echo 'Erro: '.$e->getMessage()."\n";
}
