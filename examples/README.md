# Exemplos de Uso do SDK NFS-e Nacional

Esta pasta contém exemplos de como utilizar os diversos métodos disponibilizados pelo SDK.

## Estrutura de Pastas

-   `contribuinte/`: Exemplos de operações realizadas por prestadores ou tomadores de serviço.
-   `municipio/`: Exemplos de operações realizadas por prefeituras (municípios).
-   `bootstrap.php`: Arquivo de configuração compartilhado por todos os exemplos.

## Como Executar

1. Certifique-se de que as dependências do projeto foram instaladas:

    ```bash
    composer install
    ```

2. Coloque seu certificado digital `.pfx` na pasta `examples/certs/` com o nome `contribuinte.pfx`.

3. Edite o arquivo `examples/bootstrap.php` e ajuste a senha do certificado se necessário (o padrão configurado é `Maia2040!`):

4. Execute qualquer exemplo via linha de comando:
    ```bash
    php examples/contribuinte/consultar.php
    ```

## Observações

-   Os exemplos estão configurados por padrão para o ambiente de **Homologação** (usando `TipoAmbiente::Homologacao` no `bootstrap.php`).
-   Alguns exemplos requerem chaves de acesso ou IDs de DPS reais para funcionar corretamente. Substitua os valores de exemplo pelos seus dados reais.
