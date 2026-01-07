<?php

require_once __DIR__.'/../vendor/autoload.php';

use Nfse\Http\NfseContext;
use Nfse\Nfse;

// Lista de municípios para facilitar os testes
$municipios = [
    'SAO_PAULO' => '3550308',
    'RIO_DE_JANEIRO' => '3304557',
    'FORTALEZA' => '2304400',
    'BELEM' => '1501402',
    'PACAJA' => '1505437',
    'TUCURUI' => '1508100',
    'CURITIBA' => '4106902',
    'BELO_HORIZONTE' => '3106200',
    'PORTO_ALEGRE' => '4314902',
    'BRASILIA' => '5300108',
    'RECIFE' => '2611606',
];

// Escolha o município que será usado nos exemplos
$municipioSelecionado = 'FORTALEZA';
$codigoMunicipio = $municipios[$municipioSelecionado];

// Configurações básicas para os exemplos
$certificatePath = __DIR__.'/certs/contribuinte.pfx';
$certificatePassword = 'Maia2040!';

// Se o arquivo de certificado não existir, vamos avisar (apenas para o exemplo)
if (! file_exists($certificatePath)) {
    echo "AVISO: Arquivo de certificado não encontrado em: $certificatePath\n";
    echo "Para rodar estes exemplos, coloque seu certificado .pfx na pasta examples/certs/ e ajuste a senha no arquivo bootstrap.php se necessário.\n\n";
}

$context = new NfseContext(
    ambiente: \Nfse\Enums\TipoAmbiente::Homologacao,
    certificatePath: $certificatePath,
    certificatePassword: $certificatePassword
);

$nfse = new Nfse($context);

return $nfse;
