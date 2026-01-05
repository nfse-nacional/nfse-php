# Utilitários

O pacote inclui um conjunto de classes utilitárias (`helpers`) no namespace `Nfse\Support` que facilitam tarefas comuns relacionadas ao processamento de documentos fiscais, formatação de dados e cálculos.

---

## CpfCnpjFormatter

A classe `CpfCnpjFormatter` oferece métodos estáticos para formatar e limpar documentos brasileiros (CPF, CNPJ, CEP).

### Métodos Disponíveis

#### `formatCpf(string $cpf): string`

Formata um CPF no padrão brasileiro (XXX.XXX.XXX-XX).

```php
use Nfse\Support\CpfCnpjFormatter;

echo CpfCnpjFormatter::formatCpf('12345678901');
// Saída: 123.456.789-01
```

**Parâmetros:**

-   `$cpf` - CPF sem formatação (apenas números)

**Retorno:** CPF formatado

---

#### `formatCnpj(string $cnpj): string`

Formata um CNPJ no padrão brasileiro (XX.XXX.XXX/XXXX-XX).

```php
echo CpfCnpjFormatter::formatCnpj('12345678000199');
// Saída: 12.345.678/0001-99
```

**Parâmetros:**

-   `$cnpj` - CNPJ sem formatação (apenas números)

**Retorno:** CNPJ formatado

---

#### `formatCep(string $cep): string`

Formata um CEP no padrão brasileiro (XXXXX-XXX).

```php
echo CpfCnpjFormatter::formatCep('12345678');
// Saída: 12345-678
```

**Parâmetros:**

-   `$cep` - CEP sem formatação (apenas números)

**Retorno:** CEP formatado

---

#### `unformat(string $value): string`

Remove toda a formatação de um documento, mantendo apenas os números.

```php
echo CpfCnpjFormatter::unformat('123.456.789-01');
// Saída: 12345678901

echo CpfCnpjFormatter::unformat('12.345.678/0001-99');
// Saída: 12345678000199

echo CpfCnpjFormatter::unformat('12345-678');
// Saída: 12345678
```

**Parâmetros:**

-   `$value` - Valor formatado

**Retorno:** Apenas os dígitos numéricos

**Caso de Uso:** Útil para normalizar dados antes de armazená-los no banco de dados ou enviá-los em XMLs.

---

## TaxCalculator

A classe `TaxCalculator` fornece métodos para cálculos tributários simples.

### Métodos Disponíveis

#### `calculate(float $baseCalculo, float $aliquota): float`

Calcula o valor de um imposto com base na base de cálculo e alíquota percentual.

```php
use Nfse\Support\TaxCalculator;

$baseCalculo = 1000.00;
$aliquota = 5.0; // 5%

$valorImposto = TaxCalculator::calculate($baseCalculo, $aliquota);

echo $valorImposto; // 50.00
```

**Parâmetros:**

-   `$baseCalculo` - Valor base para o cálculo
-   `$aliquota` - Alíquota em percentual (ex: 5.0 para 5%)

**Retorno:** Valor do imposto arredondado para 2 casas decimais

**Fórmula:** `(baseCalculo * aliquota) / 100`

**Exemplos Práticos:**

```php
// Calcular ISSQN (5% sobre R$ 10.000,00)
$issqn = TaxCalculator::calculate(10000.00, 5.0);
// Resultado: 500.00

// Calcular PIS (0.65% sobre R$ 5.000,00)
$pis = TaxCalculator::calculate(5000.00, 0.65);
// Resultado: 32.50

// Calcular COFINS (3% sobre R$ 5.000,00)
$cofins = TaxCalculator::calculate(5000.00, 3.0);
// Resultado: 150.00
```

---

## IdGenerator

A classe `IdGenerator` facilita a criação de identificadores únicos exigidos pelo padrão nacional de NFS-e.

### Métodos Disponíveis

#### `generateDpsId(string $cpfCnpj, string $codIbge, string $serieDps, string|int $numDps): string`

Gera o ID único da DPS (Declaração de Prestação de Serviço) seguindo o padrão nacional.

**Formato do ID:** `DPS` + Código Município (7) + Tipo Inscrição (1) + Inscrição Federal (14) + Série (5) + Número (15) = **45 caracteres**

```php
use Nfse\Support\IdGenerator;

$idDps = IdGenerator::generateDpsId(
    '12.345.678/0001-99', // CNPJ do emitente (aceita formatado ou não)
    '3550308',            // Código IBGE do município (São Paulo)
    '1',                  // Série da DPS
    '123'                 // Número da DPS
);

echo $idDps;
// Saída: DPS355030821234567800019900001000000000000123
```

**Parâmetros:**

-   `$cpfCnpj` - CPF ou CNPJ do emitente (com ou sem formatação)
-   `$codIbge` - Código IBGE do município de emissão (7 dígitos)
-   `$serieDps` - Série da DPS (até 5 caracteres, será preenchido com zeros à esquerda)
-   `$numDps` - Número da DPS (até 15 dígitos, será preenchido com zeros à esquerda)

**Retorno:** ID da DPS com 45 caracteres

**Detalhes da Composição:**

| Componente        | Posição | Tamanho | Descrição                           | Exemplo         |
| ----------------- | ------- | ------- | ----------------------------------- | --------------- |
| Prefixo           | 1-3     | 3       | Literal "DPS"                       | DPS             |
| Código Município  | 4-10    | 7       | Código IBGE                         | 3550308         |
| Tipo Inscrição    | 11      | 1       | 1=CPF, 2=CNPJ                       | 2               |
| Inscrição Federal | 12-25   | 14      | CPF/CNPJ (CPF com zeros à esquerda) | 12345678000199  |
| Série             | 26-30   | 5       | Série da DPS (zeros à esquerda)     | 00001           |
| Número            | 31-45   | 15      | Número da DPS (zeros à esquerda)    | 000000000000123 |

**Exemplo com CPF:**

```php
$idDps = IdGenerator::generateDpsId(
    '123.456.789-01',  // CPF
    '2314003',         // Várzea Alegre - CE
    'A',               // Série alfanumérica
    '46'
);

// Resultado: DPS231400310001234567890100000A000000000000046
// Tipo = 1 (CPF)
// CPF preenchido: 00012345678901
```

**Boas Práticas:**

1. **Gere o ID antes de criar o DTO:**

```php
$id = IdGenerator::generateDpsId($cnpj, $codIbge, $serie, $numero);

$dps = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        id: $id,
        // ... outros campos
    )
);
```

2. **Use os mesmos dados do emitente:**

```php
// Certifique-se de usar o mesmo CNPJ/CPF do prestador
$id = IdGenerator::generateDpsId(
    $prestador->cnpj ?? $prestador->cpf,
    $codigoMunicipio,
    $serie,
    $numeroDps
);
```

---

## CpfCnpjGenerator

A classe `CpfCnpjGenerator` gera CPFs e CNPJs **válidos** aleatórios, útil para testes e desenvolvimento.

> ⚠️ **Atenção:** Esta classe é destinada **exclusivamente para ambientes de teste e desenvolvimento**. Nunca use documentos gerados em produção.

### Métodos Disponíveis

#### `generateCpf(bool $formatted = false): string`

Gera um CPF válido aleatório com dígitos verificadores corretos.

```php
use Nfse\Support\CpfCnpjGenerator;

// CPF sem formatação
$cpf = CpfCnpjGenerator::generateCpf();
echo $cpf; // Ex: 12345678901

// CPF formatado
$cpfFormatado = CpfCnpjGenerator::generateCpf(true);
echo $cpfFormatado; // Ex: 123.456.789-01
```

**Parâmetros:**

-   `$formatted` - Se `true`, retorna formatado (XXX.XXX.XXX-XX). Padrão: `false`

**Retorno:** CPF válido (11 dígitos)

---

#### `generateCnpj(bool $formatted = false): string`

Gera um CNPJ válido aleatório com dígitos verificadores corretos.

```php
// CNPJ sem formatação
$cnpj = CpfCnpjGenerator::generateCnpj();
echo $cnpj; // Ex: 12345678000195

// CNPJ formatado
$cnpjFormatado = CpfCnpjGenerator::generateCnpj(true);
echo $cnpjFormatado; // Ex: 12.345.678/0001-95
```

**Parâmetros:**

-   `$formatted` - Se `true`, retorna formatado (XX.XXX.XXX/XXXX-XX). Padrão: `false`

**Retorno:** CNPJ válido (14 dígitos)

**Nota:** Os CNPJs gerados sempre usam `0001` como número de filial.

---

### Casos de Uso para CpfCnpjGenerator

**1. Testes Unitários:**

```php
it('validates CPF format', function () {
    $cpf = CpfCnpjGenerator::generateCpf();

    expect($cpf)->toHaveLength(11)
        ->and($cpf)->toMatch('/^\d{11}$/');
});
```

**2. Seeders de Banco de Dados:**

```php
// database/seeders/ClienteSeeder.php
use Nfse\Support\CpfCnpjGenerator;

for ($i = 0; $i < 100; $i++) {
    Cliente::create([
        'nome' => fake()->name(),
        'cpf' => CpfCnpjGenerator::generateCpf(),
        'email' => fake()->email(),
    ]);
}
```

**3. Dados de Demonstração:**

```php
// Criar DPS de exemplo para demonstração
$dpsDemo = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        // ...
        prestador: new PrestadorData(
            cnpj: CpfCnpjGenerator::generateCnpj(),
            nome: 'Empresa Demonstração Ltda',
            // ...
        ),
        tomador: new TomadorData(
            cpf: CpfCnpjGenerator::generateCpf(),
            nome: 'Cliente Exemplo',
            // ...
        )
    )
);
```

---

## Resumo das Classes

| Classe             | Propósito                   | Principais Métodos                                         |
| ------------------ | --------------------------- | ---------------------------------------------------------- |
| `CpfCnpjFormatter` | Formatação de documentos    | `formatCpf()`, `formatCnpj()`, `formatCep()`, `unformat()` |
| `TaxCalculator`    | Cálculos tributários        | `calculate()`                                              |
| `IdGenerator`      | Geração de IDs únicos       | `generateDpsId()`                                          |
| `CpfCnpjGenerator` | Geração de docs para testes | `generateCpf()`, `generateCnpj()`                          |

---

## Exemplo Integrado

Veja como usar múltiplos utilitários em conjunto:

```php
use Nfse\Support\{CpfCnpjFormatter, TaxCalculator, IdGenerator, CpfCnpjGenerator};

// 1. Gerar documentos para teste
$cnpjPrestador = CpfCnpjGenerator::generateCnpj();
$cpfTomador = CpfCnpjGenerator::generateCpf();

// 2. Formatar para exibição
echo "Prestador: " . CpfCnpjFormatter::formatCnpj($cnpjPrestador) . "\n";
echo "Tomador: " . CpfCnpjFormatter::formatCpf($cpfTomador) . "\n";

// 3. Calcular impostos
$valorServico = 10000.00;
$aliquotaIss = 5.0;
$valorIss = TaxCalculator::calculate($valorServico, $aliquotaIss);

echo "Valor do Serviço: R$ " . number_format($valorServico, 2, ',', '.') . "\n";
echo "ISS (5%): R$ " . number_format($valorIss, 2, ',', '.') . "\n";

// 4. Gerar ID da DPS
$idDps = IdGenerator::generateDpsId(
    CpfCnpjFormatter::unformat($cnpjPrestador), // Remove formatação
    '3550308',
    '1',
    '1'
);

echo "ID da DPS: " . $idDps . "\n";
```

**Saída:**

```
Prestador: 12.345.678/0001-95
Tomador: 123.456.789-01
Valor do Serviço: R$ 10.000,00
ISS (5%): R$ 500,00
ID da DPS: DPS355030821234567800019500001000000000000001
```
