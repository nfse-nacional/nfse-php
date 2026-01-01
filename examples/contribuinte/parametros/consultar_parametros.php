<?php

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__ . '/../../bootstrap.php';

try {
    // $codigoMunicipio já vem do bootstrap.php
    
    echo "Consultando parâmetros do convênio para o município: $codigoMunicipio ($municipioSelecionado)...\n";
    
    $response = $nfse->contribuinte()->consultarParametrosConvenio($codigoMunicipio);
    
    echo "Mensagem: " . $response->mensagem . "\n";
    if ($response->parametrosConvenio) {
        echo "Tipo Convênio: " . $response->parametrosConvenio->tipoConvenio . "\n";
        echo "Aderente Emissor Nacional: " . ($response->parametrosConvenio->aderenteEmissorNacional ? 'Sim' : 'Não') . "\n";
    }
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
