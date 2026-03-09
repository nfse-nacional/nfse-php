<?php

use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Http\NfseContext;
use Nfse\Nfse;

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__ . '/../bootstrap.php';

try {
    // 1. Configuração do Contexto (Certificado e Ambiente)
    // $certificatePath = __DIR__.'/certs/cert.pfx';
    // $certificatePassword = 'senha';

    $context = new NfseContext(
        ambiente: \Nfse\Enums\TipoAmbiente::Homologacao,
        certificatePath: $certificatePath,
        certificatePassword: $certificatePassword
    );

    $nfse = new Nfse($context);

    // 2. Dados para o Cancelamento
    $chaveNfse = '35503080000000000000000000000000000000000000'; // Chave da nota a ser cancelada
    $cnpjAutor = '03279735000194'; // CNPJ do Prestador

    $eventoData = new PedRegEventoData([
        'versao' => '1.01',
        'infPedReg' => [
            'tpAmb' => 2, // 1-Produção, 2-Homologação
            'verAplic' => 'SDK-PHP-1.0',
            'dhEvento' => date('c'),
            'chNFSe' => $chaveNfse,
            'cnpjAutor' => $cnpjAutor,
            'tipoEvento' => '101101', // Código para Cancelamento
            'e101101' => [
                // XSD v1.01 (TE101101): valor fixo enumerado para xDesc.
                'xDesc' => 'Cancelamento de NFS-e',
                'cMotivo' => '1', // 1 - Erro na emissão
                'xMotivo' => 'Teste de cancelamento via SDK PHP',
            ],
        ],
    ]);

    echo "Cancelando NFS-e: $chaveNfse...\n";

    /**
     * Você pode usar o método direto (se disponível no Service)
     * ou montar o processo manualmente caso a versão do SDK seja anterior.
     *
     * Neste exemplo, demonstramos como seria a chamada simplificada:
     */
    $response = $nfse->contribuinte()->cancelar($eventoData);

    if ($response->identificadorMetodo === 'RE_SUCESSO') {
        echo "NFS-e cancelada com sucesso!\n";
    } else {
        echo "Aguardando processamento ou erro: " . $response->identificadorMetodo . "\n";
    }
} catch (\Exception $e) {
    echo 'Erro: ' . $e->getMessage() . "\n";
}
