<?php

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__ . '/../bootstrap.php';

try {
    $nsu = 1;

    $filesDir = __DIR__ . '/../files/';
    if (! is_dir($filesDir)) {
        mkdir($filesDir, 0777, true);
    }

    do {
        $tentativas = 0;
        $maxTentativas = 3;
        $sucesso = false;
        $response = null;

        while ($tentativas < $maxTentativas && !$sucesso) {
            try {
                $tentativas++;
                echo "Baixando DF-e para o municipio (NSU: $nsu)... ";

                $response = $nfse->contribuinte()->baixarDfe($nsu);
                $sucesso = true;
                echo "OK!\n";
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();

                // Se não houver mais documentos, encerra o loop graciosamente
                if (strpos($errorMsg, 'E2220') !== false || strpos($errorMsg, 'NENHUM_DOCUMENTO_LOCALIZADO') !== false) {
                    echo "Nenhum novo documento localizado desde o NSU $nsu.\n";
                    break 2; // Sai do while e do do-while
                }

                echo "Erro na tentativa $tentativas: $errorMsg\n";

                if ($tentativas < $maxTentativas) {
                    $espera = $tentativas * 10;
                    echo "Aguardando {$espera} segundos para nova tentativa...\n";
                    sleep($espera);
                } else {
                    echo "Limite de tentativas atingido para o NSU $nsu.\n";
                    break 2;
                }
            }
        }

        if ($response) {
            echo 'NSU Final: ' . $response->ultimoNsu . " | Documentos: " . count($response->listaNsu) . "\n";

            foreach ($response->listaNsu as $item) {
                $xmlContent = gzdecode(base64_decode($item->dfeXmlGZipB64));

                if ($xmlContent === false) {
                    echo "Erro ao descompactar GZIP para NSU {$item->nsu}\n";
                    continue;
                }

                $xmlPath = $filesDir . $item->nsu . '.xml';
                file_put_contents($xmlPath, $xmlContent);
                echo "Salvo: $item->nsu.xml\n";
            }

            $antigoNsu = $nsu;
            $nsu = (int) $response->ultimoNsu;

            if (count($response->listaNsu) > 0) {
                echo "Aguardando 5 segundos para a próxima sequência...\n";
                sleep(5);
            }
        }
    } while ($response && $nsu > $antigoNsu && count($response->listaNsu) > 0);

    echo "Processamento concluído.\n";
} catch (\Exception $e) {
    echo 'Erro Crítico: ' . $e->getMessage() . "\n";
}
