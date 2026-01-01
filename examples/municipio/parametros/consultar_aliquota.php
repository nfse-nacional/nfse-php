<?php

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__ . '/../../bootstrap.php';

try {
    // $codigoMunicipio já vem do bootstrap.php
    $codigoServico = '01.01.00.001'; // O código deve ter 9 dígitos no formato 00.00.00.000
    $competencia = '2025-01-01T12:00:00';
    
    echo "Consultando alíquota para o serviço $codigoServico no município $codigoMunicipio...\n";
    
    $response = $nfse->municipio()->consultarAliquota($codigoMunicipio, $codigoServico, $competencia);
    
    echo "Mensagem: " . $response->mensagem . "\n";
    if (isset($response->aliquotas[$codigoServico])) {
        foreach ($response->aliquotas[$codigoServico] as $aliquota) {
            echo "Alíquota: " . $aliquota->aliquota . "%\n";
        }
    }
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
