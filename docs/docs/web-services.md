# Web Services (SDK) 🌐

O `nfse-php` fornece um cliente HTTP robusto para integração direta com os Web Services da SEFIN Nacional e do Ambiente de Dados Nacional (ADN).

## Configuração do Contexto

Toda a comunicação com os Web Services exige um certificado digital (P12) e a definição do ambiente (Produção ou Homologação).

```php
use Nfse\Http\NfseContext;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    certificatePath: '/caminho/para/seu/certificado.p12',
    certificatePassword: 'sua-senha-aqui',
    ambiente: TipoAmbiente::Homologacao
);
```

## Sefin Nacional (Emissão e Consulta)

O `SefinClient` é responsável pelas operações principais de emissão de NFS-e, consulta de documentos e registro de eventos.

```php
use Nfse\Http\Client\SefinClient;

$sefin = new SefinClient($context);

// 1. Emitir NFS-e (Enviando o XML da DPS compactado em GZip e Base64)
$response = $sefin->emitirNfse($dpsXmlGZipB64);

if ($response->erros) {
    // Tratar erros de processamento
    foreach ($response->erros as $erro) {
        echo "Erro {$erro->codigo}: {$erro->descricao}\n";
    }
} else {
    echo "NFS-e emitida com sucesso!\n";
    echo "Chave de Acesso: {$response->chaveAcesso}\n";
}

// 2. Consultar NFS-e pela Chave de Acesso
$nfse = $sefin->consultarNfse('35231012345678000199550010000000011234567890');

// 3. Verificar existência de DPS
$existe = $sefin->verificarDps('DPS35503081123456780001990000100000000000001');
```

### Métodos Disponíveis no SefinClient

| Método                                                           | Descrição                                             |
| :--------------------------------------------------------------- | :---------------------------------------------------- |
| `emitirNfse(string $dpsXmlGZipB64)`                              | Envia uma DPS para emissão de NFS-e.                  |
| `consultarNfse(string $chaveAcesso)`                             | Recupera os dados e o XML de uma NFS-e.               |
| `consultarDps(string $idDps)`                                    | Consulta o status de uma DPS enviada.                 |
| `registrarEvento(string $chaveAcesso, string $eventoXmlGZipB64)` | Registra eventos (ex: Cancelamento) em uma NFS-e.     |
| `verificarDps(string $idDps)`                                    | Verifica se uma DPS já foi processada (HEAD request). |
| `listarEventos(string $chaveAcesso)`                             | Lista todos os eventos vinculados a uma NFS-e.        |

---

## ADN (Ambiente de Dados Nacional)

O `AdnClient` permite interagir com serviços auxiliares, como a obtenção do DANFSe (PDF) e consulta de parâmetros municipais.

```php
use Nfse\Http\Client\AdnClient;

$adn = new AdnClient($context);

// 1. Obter DANFSe (Retorna o conteúdo binário do PDF)
$pdfContent = $adn->obterDanfse($chaveAcesso);
file_put_contents('nota.pdf', $pdfContent);

// 2. Consultar Parâmetros de Convênio do Município
$parametros = $adn->consultarParametrosConvenio('3550308'); // São Paulo
```

### Métodos Disponíveis no AdnClient

| Método                                                 | Descrição                                                 |
| :----------------------------------------------------- | :-------------------------------------------------------- |
| `obterDanfse(string $chaveAcesso)`                     | Retorna o PDF do Documento Auxiliar da NFS-e.             |
| `consultarParametrosConvenio(string $codigoMunicipio)` | Consulta as regras e convênios de um município.           |
| `consultarAliquota(...)`                               | Consulta a alíquota vigente para um serviço no município. |
| `consultarRegimesEspeciais(...)`                       | Consulta regimes especiais de tributação do município.    |

:::tip Formato dos Parâmetros (ADN)
Ao utilizar métodos de parametrização municipal (como `consultarAliquota`), observe as seguintes regras:

-   **Código do Serviço**: Deve ser informado no formato `00.00.00.000` (9 dígitos com pontos).
-   **Competência**: Deve seguir o padrão ISO8601 (ex: `2025-01-01T12:00:00`).
    :::

---

## Tratamento de Erros

A biblioteca lança exceções do tipo `NfseApiException` para erros de rede ou respostas inválidas da API.

```php
use Nfse\Http\Exceptions\NfseApiException;

try {
    $response = $sefin->emitirNfse($xml);
} catch (NfseApiException $e) {
    echo "Erro na comunicação: " . $e->getMessage();
    echo "Código HTTP: " . $e->getCode();
}
```
