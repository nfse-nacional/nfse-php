<?php

use Nfse\Dto\Nfse\DpsData;
use Nfse\Http\NfseContext;
use Nfse\Nfse;
use Nfse\Support\IdGenerator;

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__.'/../bootstrap.php';

try {
    // $certificatePath = __DIR__.'/certs/cert.pfx';
    // $certificatePassword = 'senha';

    $context = new NfseContext(
        ambiente: \Nfse\Enums\TipoAmbiente::Homologacao,
        certificatePath: $certificatePath,
        certificatePassword: $certificatePassword
    );

    $nfse = new Nfse($context);

    date_default_timezone_set('America/Sao_Paulo');
    $cnpjPrestador = '03279735000194';
    $codigoMunicipio = '2304400';
    $serie = '1';
    $numero = '100';

    $idDps = IdGenerator::generateDpsId(
        cpfCnpj: $cnpjPrestador,
        codIbge: $codigoMunicipio,
        serieDps: $serie,
        numDps: $numero
    );

    $dps = new DpsData([
        '@attributes' => [
            'versao' => '1.00',
        ],
        'infDPS' => [
            '@attributes' => [
                'Id' => $idDps,
            ],
            'tpAmb' => 2, // Homologação
            'dhEmi' => date('c'),
            'verAplic' => 'SDK-PHP-1.0',
            'serie' => $serie,
            'nDPS' => $numero,
            'dCompet' => date('Y-m-d'),
            'tpEmit' => 1, // Prestador
            'cLocEmi' => $codigoMunicipio,

            'prest' => [
                'CNPJ' => $cnpjPrestador,
                'xNome' => 'Empresa de Teste',
                'end' => [
                    'endNac' => [
                        'cMun' => $codigoMunicipio,
                        'CEP' => '60000000',
                    ],
                    'xLgr' => 'Rua Teste',
                    'nro' => '123',
                    'xCpl' => 'Sala 1',
                    'xBairro' => 'Centro',
                ],
                'fone' => '85999999999',
                'email' => 'teste@empresa.com.br',
                'regTrib' => [
                    'opSimpNac' => 1, // Não Optante 2 optante (MEI) 3-Optante (ME/EPP)
                    'regApTribSN' => null,  
                    'regEspTrib' => 0, // Nenhum
                ],
            ],
            'toma' => [
                'CNPJ' => '44827692000111',
                'xNome' => 'Cliente de Teste',
            ],
            'serv' => [
                'locPrest' => [
                    'cLocPrestacao' => $codigoMunicipio,
                ],
                'cServ' => [
                    'cTribNac' => '010101',
                    'xDescServ' => 'Desenvolvimento de Software',
                ],
            ],
            'valores' => [
                'vServPrest' => [
                    'vServ' => 100.00,
                ],
                'trib' => [
                    'tribMun' => [
                        'tribISSQN' => 1,
                        'tpRetISSQN' => 1,
                    ],
                    'tribFed' => [
                        'piscofins' => [
                            'CST' => '08',
                        ],
                    ],
                    'totTrib' => [
                        'indTotTrib' => 0,
                    ],
                ],
            ],
        ],
    ]);

    echo "Emitindo NFS-e para a DPS: $idDps...\n";

    $nfseData = $nfse->contribuinte()->emitir($dps);

    echo "NFS-e emitida com sucesso!\n";
    echo 'Chave de Acesso: '.$nfseData->infNfse->id."\n";

} catch (\Exception $e) {
    echo 'Erro: '.$e->getMessage()."\n";
}
