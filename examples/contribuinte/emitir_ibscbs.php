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
            'dCompet' => date('Y-m-d'), // O grupo IBSCBS só é aceito a partir de 01/01/2026
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
                    'xBairro' => 'Centro',
                ],
                'regTrib' => [
                    'opSimpNac' => 1, // Não Optante
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
                    // O item da NBS é obrigatório quando o grupo IBSCBS é informado
                    'cNBS' => '112011000',
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
                    'totTrib' => [
                        'indTotTrib' => 0,
                    ],
                ],
            ],
            'IBSCBS' => [
                'finNFSe' => '0', // NFS-e regular
                'cIndOp' => '010101', // Código indicador da operação (Anexo VII)
                'indDest' => 0, // O destinatário é o próprio tomador
                'valores' => [
                    'trib' => [
                        'gIBSCBS' => [
                            'CST' => '000', // Tributação integral
                            'cClassTrib' => '000001',
                        ],
                    ],
                ],
            ],
        ],
    ]);

    echo "Emitindo NFS-e com IBS/CBS para a DPS: $idDps...\n";

    $nfseData = $nfse->contribuinte()->emitir($dps);

    echo "NFS-e emitida com sucesso!\n";
    echo 'Chave de Acesso: '.$nfseData->infNfse->id."\n";

    $ibscbs = $nfseData->infNfse->ibscbs;

    if ($ibscbs) {
        echo 'Localidade de incidência: '.$ibscbs->nomeLocalidadeIncidencia."\n";
        echo 'Base de cálculo IBS/CBS: '.$ibscbs->baseCalculo."\n";
        echo 'IBS total: '.$ibscbs->valorTotalIbs."\n";
        echo 'CBS: '.$ibscbs->valorCbs."\n";
        echo 'Valor total da nota com os tributos por fora: '.$ibscbs->valorTotalNota."\n";
    }

} catch (\Exception $e) {
    echo 'Erro: '.$e->getMessage()."\n";
}
