#!/usr/bin/env php
<?php

/**
 * Compara DTOs entre duas versões
 * 
 * Uso: php scripts/compare_dto_versions.php [versao1] [versao2]
 * Exemplo: php scripts/compare_dto_versions.php 1.0.0 1.0.1
 */

$version1 = $argv[1] ?? '1.0.0';
$version2 = $argv[2] ?? '1.0.1';

$dir1 = __DIR__ . "/../src/Dto/V" . str_replace('.', '_', $version1);
$dir2 = __DIR__ . "/../src/Dto/V" . str_replace('.', '_', $version2);

if (!is_dir($dir1)) {
    echo "❌ Diretório não encontrado: {$dir1}\n";
    exit(1);
}

if (!is_dir($dir2)) {
    echo "❌ Diretório não encontrado: {$dir2}\n";
    exit(1);
}

echo "🔍 Comparando DTOs entre versões {$version1} e {$version2}\n\n";

// Coletar arquivos de cada versão
$files1 = collectPhpFiles($dir1);
$files2 = collectPhpFiles($dir2);

// Normalizar caminhos relativos
$relativeFiles1 = array_map(fn($f) => str_replace($dir1 . '/', '', $f), $files1);
$relativeFiles2 = array_map(fn($f) => str_replace($dir2 . '/', '', $f), $files2);

// Encontrar diferenças
$onlyIn1 = array_diff($relativeFiles1, $relativeFiles2);
$onlyIn2 = array_diff($relativeFiles2, $relativeFiles1);
$inBoth = array_intersect($relativeFiles1, $relativeFiles2);

// Estatísticas
echo "📊 Estatísticas:\n";
echo "  • Arquivos em v{$version1}: " . count($relativeFiles1) . "\n";
echo "  • Arquivos em v{$version2}: " . count($relativeFiles2) . "\n";
echo "  • Arquivos em comum: " . count($inBoth) . "\n";
echo "  • Apenas em v{$version1}: " . count($onlyIn1) . "\n";
echo "  • Apenas em v{$version2}: " . count($onlyIn2) . "\n\n";

// Arquivos apenas na versão 1
if (!empty($onlyIn1)) {
    echo "❌ Arquivos REMOVIDOS na v{$version2} (existem apenas em v{$version1}):\n";
    foreach ($onlyIn1 as $file) {
        echo "  - {$file}\n";
    }
    echo "\n";
}

// Arquivos apenas na versão 2
if (!empty($onlyIn2)) {
    echo "✅ Arquivos NOVOS na v{$version2} (não existem em v{$version1}):\n";
    foreach ($onlyIn2 as $file) {
        echo "  - {$file}\n";
    }
    echo "\n";
}

// Comparar conteúdo dos arquivos em comum
echo "🔄 Analisando diferenças de conteúdo...\n\n";

$modified = [];
$identical = 0;

foreach ($inBoth as $relativeFile) {
    $file1 = $dir1 . '/' . $relativeFile;
    $file2 = $dir2 . '/' . $relativeFile;
    
    $content1 = file_get_contents($file1);
    $content2 = file_get_contents($file2);
    
    // Normalizar para comparação (remover comentários de versão)
    $content1Clean = preg_replace('/\* Gerado automaticamente do schema XSD versão .*/', '', $content1);
    $content2Clean = preg_replace('/\* Gerado automaticamente do schema XSD versão .*/', '', $content2);
    
    if ($content1Clean !== $content2Clean) {
        $modified[] = [
            'file' => $relativeFile,
            'diff' => compareProperties($file1, $file2)
        ];
    } else {
        $identical++;
    }
}

echo "📝 Arquivos modificados: " . count($modified) . "\n";
echo "✓ Arquivos idênticos: {$identical}\n\n";

if (!empty($modified)) {
    echo "📋 Detalhes das modificações:\n\n";
    
    foreach (array_slice($modified, 0, 20) as $mod) {
        echo "  📄 {$mod['file']}\n";
        if (!empty($mod['diff'])) {
            foreach ($mod['diff'] as $change) {
                echo "    {$change}\n";
            }
        }
        echo "\n";
    }
    
    if (count($modified) > 20) {
        echo "  ... e mais " . (count($modified) - 20) . " arquivos modificados\n\n";
    }
}

// Resumo final
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📌 RESUMO:\n";
echo "  • Total de DTOs em v{$version1}: " . count($relativeFiles1) . "\n";
echo "  • Total de DTOs em v{$version2}: " . count($relativeFiles2) . "\n";
echo "  • Novos DTOs: " . count($onlyIn2) . "\n";
echo "  • DTOs removidos: " . count($onlyIn1) . "\n";
echo "  • DTOs modificados: " . count($modified) . "\n";
echo "  • DTOs sem alteração: {$identical}\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

/**
 * Coleta recursivamente todos os arquivos PHP de um diretório
 */
function collectPhpFiles(string $dir): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
    
    sort($files);
    return $files;
}

/**
 * Compara propriedades entre dois arquivos PHP
 */
function compareProperties(string $file1, string $file2): array
{
    $props1 = extractProperties($file1);
    $props2 = extractProperties($file2);
    
    $changes = [];
    
    // Propriedades adicionadas
    $added = array_diff($props2, $props1);
    foreach ($added as $prop) {
        $changes[] = "    ✅ Adicionado: {$prop}";
    }
    
    // Propriedades removidas
    $removed = array_diff($props1, $props2);
    foreach ($removed as $prop) {
        $changes[] = "    ❌ Removido: {$prop}";
    }
    
    return $changes;
}

/**
 * Extrai nomes de propriedades públicas de um arquivo PHP
 */
function extractProperties(string $file): array
{
    $content = file_get_contents($file);
    preg_match_all('/public\s+\??[\w\\\\]+\s+\$(\w+)/', $content, $matches);
    return $matches[1] ?? [];
}
