# Geração de DTOs - NFSe Nacional

Este projeto possui dois geradores de DTOs para trabalhar com diferentes fontes de schema:

## 1. Gerador baseado em CSV (`generate_dtos.php`)

Gera DTOs a partir do arquivo CSV consolidado `references/schemas/dps-nfse-schema.csv`.

### Uso:

```bash
php scripts/generate_dtos.php
```

### Saída:

-   DTOs gerados em: `src/Dto/`
-   Estrutura hierárquica baseada nos caminhos do CSV

### Quando usar:

-   Para gerar DTOs da versão atual/consolidada
-   Quando trabalhar com o schema CSV mantido manualmente

---

## 2. Gerador baseado em XSD (`generate_dtos_from_xsd.php`)

Gera DTOs diretamente dos arquivos XSD oficiais, suportando múltiplas versões.

### Uso:

```bash
# Gerar DTOs para versão 1.0.0 (padrão)
php scripts/generate_dtos_from_xsd.php

# Gerar DTOs para versão 1.0.1
php scripts/generate_dtos_from_xsd.php 1.0.1

# Gerar DTOs para versão específica
php scripts/generate_dtos_from_xsd.php <versão>
```

### Saída:

-   DTOs gerados em: `src/Dto/V1_0_0/` (para versão 1.0.0)
-   DTOs gerados em: `src/Dto/V1_0_1/` (para versão 1.0.1)
-   Namespace: `Nfse\Dto\V1_0_0\...` (versionado)
-   Estrutura organizada por namespace
-   Inclui metadados da versão do schema

**Exemplo de namespace gerado:**

```php
namespace Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS;

class InfDPSData {
    // ...
}
```

### Quando usar:

-   Para gerar DTOs de versões específicas do schema
-   Quando precisar de compatibilidade com múltiplas versões
-   Para validar contra schemas XSD oficiais

---

## Estrutura de Schemas

```
references/schemas/
├── dps-nfse-schema.csv          # Schema consolidado (CSV)
├── v1.0.0/                       # Schemas XSD versão 1.0.0
│   ├── DPS_v1.00.xsd
│   ├── NFSe_v1.00.xsd
│   ├── evento_v1.00.xsd
│   ├── tiposComplexos_v1.00.xsd
│   ├── tiposSimples_v1.00.xsd
│   └── ...
└── v1.0.1/                       # Schemas XSD versão 1.0.1
    ├── DPS_v1.01.xsd
    ├── NFSe_v1.01.xsd
    ├── evento_v1.01.xsd
    ├── tiposComplexos_v1.01.xsd
    └── ...
```

---

## Comparação

| Característica | CSV Generator  | XSD Generator           |
| -------------- | -------------- | ----------------------- |
| Fonte          | CSV manual     | XSD oficial             |
| Versões        | Única (atual)  | Múltiplas               |
| Saída          | `src/Dto/`     | `src/Dto/V{versão}/`    |
| Namespace      | `Nfse\Dto\...` | `Nfse\Dto\V1_0_0\...`   |
| Metadados      | Limitados      | Completos (tipos, docs) |
| Manutenção     | Manual         | Automática              |
| Coexistência   | Não            | Sim (múltiplas versões) |

---

## Adicionando Nova Versão

Para adicionar suporte a uma nova versão do schema:

1. Crie o diretório da versão:

    ```bash
    mkdir references/schemas/v1.0.2
    ```

2. Adicione os arquivos XSD oficiais:

    ```bash
    cp /path/to/official/schemas/*.xsd references/schemas/v1.0.2/
    ```

3. Gere os DTOs:
    ```bash
    php scripts/generate_dtos_from_xsd.php 1.0.2
    ```

---

## Usando DTOs Versionados

### Importação por Versão

```php
// Versão 1.0.0
use Nfse\Dto\V1_0_0\NFSe\CNFSeData as NFSeV1;
use Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS\CDPSData as DPSV1;

// Versão 1.0.1
use Nfse\Dto\V1_0_1\NFSe\CNFSeData as NFSeV2;
use Nfse\Dto\V1_0_1\NFSe\InfNFSe\DPS\CDPSData as DPSV2;
```

### Criação de Instâncias

```php
// Criar NFSe usando versão 1.0.0
$nfseV1 = \map(NFSeV1::class, [
    'versao' => '1.00',
    'infNFSe' => [
        'id' => 'NFS123',
        // ...
    ]
]);

// Criar NFSe usando versão 1.0.1
$nfseV2 = \map(NFSeV2::class, [
    'versao' => '1.01',
    'infNFSe' => [
        'id' => 'NFS456',
        // ...
    ]
]);
```

### Detecção Dinâmica de Versão

```php
function createNfseByVersion(string $version, array $data) {
    $versionNs = 'V' . str_replace('.', '_', $version);
    $class = "Nfse\\Dto\\{$versionNs}\\NFSe\\CNFSeData";

    return \map($class, $data);
}

$nfse = createNfseByVersion('1.0.1', $data);
```

### Exemplo Completo

Veja `examples/versioned_dtos_usage.php` para exemplos completos incluindo:

-   Uso de múltiplas versões simultaneamente
-   Migração de dados entre versões
-   Validação de compatibilidade
-   Criação dinâmica por versão

---

## Geração de Testes

Após gerar os DTOs, você pode gerar testes automaticamente:

```bash
php scripts/generate_dto_tests.php
```

Os testes são gerados em `tests/Unit/Dto/Generated/` e validam:

-   Instanciação via helper `map()`
-   Mapeamento de propriedades
-   Tipos de dados
