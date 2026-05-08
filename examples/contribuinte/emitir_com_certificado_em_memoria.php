<?php

use Nfse\Dto\Nfse\DpsData;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\NfseContext;
use Nfse\Nfse;
use Nfse\Support\IdGenerator;

require_once __DIR__.'/../../vendor/autoload.php';

// 1. Lendo de banco de dados
// $pfxContent = $pdo->query("SELECT conteudo FROM certificados WHERE id = 1")->fetchColumn();

// 2. Lendo de variável de ambiente em base64
// $pfxContent = base64_decode(getenv('CERTIFICADO_PFX_BASE64'));

// 3. Lendo de um arquivo (equivalente ao comportamento anterior)
$pfxContent = file_get_contents(__DIR__.'/../certs/contribuinte.pfx');

$certificatePassword = '[PASSWORD]';

// Passa certificateContent em vez de certificatePath
$context = new NfseContext(
    ambiente: TipoAmbiente::Homologacao,
    certificatePath: null,
    certificatePassword: $certificatePassword,
    certificateContent: $pfxContent,
);

$nfse = new Nfse($context);

try {
    $cnpjPrestador   = '03279735000194';
    $codigoMunicipio = '2304400';
    $serie           = '1';
    $numero          = '100';

    $idDps = IdGenerator::generateDpsId(
        cpfCnpj: $cnpjPrestador,
        codIbge: $codigoMunicipio,
        serieDps: $serie,
        numDps: $numero
    );

    $dps = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => $idDps],
            'tpAmb'    => 2,
            'dhEmi'    => date('c'),
            'verAplic' => 'SDK-PHP-1.0',
            'serie'    => $serie,
            'nDPS'     => $numero,
            'dCompet'  => date('Y-m-d'),
            'tpEmit'   => 1,
            'cLocEmi'  => $codigoMunicipio,
            'prest' => [
                'CNPJ'  => $cnpjPrestador,
                'xNome' => 'Empresa de Teste',
                'end'   => [
                    'endNac' => ['cMun' => $codigoMunicipio, 'CEP' => '60000000'],
                    'xLgr'   => 'Rua Teste',
                    'nro'    => '123',
                    'xBairro' => 'Centro',
                ],
                'regTrib' => ['opSimpNac' => 1, 'regEspTrib' => 0],
            ],
            'toma' => [
                'CNPJ'  => '44827692000111',
                'xNome' => 'Cliente de Teste',
            ],
            'serv' => [
                'locPrest' => ['cLocPrestacao' => $codigoMunicipio],
                'cServ'    => ['cTribNac' => '010101', 'xDescServ' => 'Desenvolvimento de Software'],
            ],
            'valores' => [
                'vServPrest' => ['vServ' => 100.00],
                'trib' => [
                    'tribMun' => ['tribISSQN' => 1, 'tpRetISSQN' => 1],
                    'tribFed' => ['piscofins' => ['CST' => '08']],
                    'totTrib' => ['indTotTrib' => 0],
                ],
            ],
        ],
    ]);

    $nfseData = $nfse->contribuinte()->emitir($dps);

    echo "NFS-e emitida com sucesso!\n";
    echo 'Chave de Acesso: '.$nfseData->infNfse->id."\n";

} catch (\Exception $e) {
    echo 'Erro: '.$e->getMessage()."\n";
}
