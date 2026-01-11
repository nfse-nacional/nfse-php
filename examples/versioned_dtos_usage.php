<?php

/**
 * Exemplo de uso de DTOs versionados
 * 
 * Este exemplo demonstra como trabalhar com múltiplas versões
 * do schema NFSe simultaneamente.
 */

require __DIR__ . '/../vendor/autoload.php';

// ============================================
// Exemplo 1: Usando DTOs da versão 1.0.0
// ============================================

use Nfse\Dto\V1_0_0\NFSe\CNFSeData as NFSeV1_0_0;

echo "=== Trabalhando com Schema v1.0.0 ===\n\n";

$nfseV1 = \map(NFSeV1_0_0::class, [
    'versao' => '1.00',
    'infNFSe' => [
        // Dados da NFSe versão 1.0.0
    ]
]);

echo "NFSe v1.0.0 criada com sucesso!\n";
echo "Namespace: " . get_class($nfseV1) . "\n\n";

// ============================================
// Exemplo 2: Usando DTOs da versão 1.0.1
// ============================================

use Nfse\Dto\V1_0_1\NFSe\CNFSeData as NFSeV1_0_1;

echo "=== Trabalhando com Schema v1.0.1 ===\n\n";

$nfseV2 = \map(NFSeV1_0_1::class, [
    'versao' => '1.01',
    'infNFSe' => [
        // Dados da NFSe versão 1.0.1
        // Pode ter campos diferentes da v1.0.0
    ]
]);

echo "NFSe v1.0.1 criada com sucesso!\n";
echo "Namespace: " . get_class($nfseV2) . "\n\n";

// ============================================
// Exemplo 3: Função para detectar versão
// ============================================

function createNfseByVersion(string $version, array $data)
{
    $versionNamespace = 'V' . str_replace('.', '_', $version);
    $className = "Nfse\\Dto\\{$versionNamespace}\\NFSe\\CNFSeData";
    
    if (!class_exists($className)) {
        throw new Exception("DTOs para versão {$version} não encontrados. Execute: php scripts/generate_dtos_from_xsd.php {$version}");
    }
    
    return \map($className, $data);
}

echo "=== Criação dinâmica por versão ===\n\n";

try {
    $nfse = createNfseByVersion('1.0.0', [
        'versao' => '1.00',
        'infNFSe' => []
    ]);
    echo "✓ NFSe criada dinamicamente para versão 1.0.0\n";
} catch (Exception $e) {
    echo "✗ Erro: " . $e->getMessage() . "\n";
}

// ============================================
// Exemplo 4: Migração entre versões
// ============================================

echo "\n=== Migração entre versões ===\n\n";

/**
 * Converte dados de uma versão para outra
 * (Implementação simplificada - em produção seria mais complexa)
 */
function migrateNfseData(array $dataV1, string $fromVersion, string $toVersion): array
{
    echo "Migrando dados de v{$fromVersion} para v{$toVersion}...\n";
    
    // Aqui você implementaria a lógica de migração
    // mapeando campos antigos para novos, adicionando defaults, etc.
    
    $dataV2 = $dataV1;
    
    // Exemplo: atualizar versão
    $dataV2['versao'] = str_replace('.', '', $toVersion);
    
    return $dataV2;
}

$dadosV1 = [
    'versao' => '1.00',
    'infNFSe' => [
        'id' => 'NFS123',
        // ... outros campos
    ]
];

$dadosV2 = migrateNfseData($dadosV1, '1.0.0', '1.0.1');
echo "✓ Dados migrados com sucesso!\n";

// ============================================
// Exemplo 5: Validação de compatibilidade
// ============================================

echo "\n=== Validação de compatibilidade ===\n\n";

function validateSchemaVersion(string $xmlVersion): string
{
    // Mapear versão do XML para versão do namespace
    $versionMap = [
        '1.00' => '1.0.0',
        '1.01' => '1.0.1',
    ];
    
    if (!isset($versionMap[$xmlVersion])) {
        throw new Exception("Versão {$xmlVersion} não suportada");
    }
    
    return $versionMap[$xmlVersion];
}

try {
    $schemaVersion = validateSchemaVersion('1.00');
    echo "✓ Versão 1.00 mapeada para schema {$schemaVersion}\n";
    
    $schemaVersion = validateSchemaVersion('1.01');
    echo "✓ Versão 1.01 mapeada para schema {$schemaVersion}\n";
} catch (Exception $e) {
    echo "✗ Erro: " . $e->getMessage() . "\n";
}

echo "\n=== Exemplo concluído ===\n";
