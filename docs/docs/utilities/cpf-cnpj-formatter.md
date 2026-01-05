# CpfCnpjFormatter

A classe `CpfCnpjFormatter` oferece métodos estáticos para formatar e limpar documentos brasileiros (CPF, CNPJ, CEP).

## Instalação

Esta classe faz parte do pacote principal e está disponível no namespace `Nfse\Support`.

```php
use Nfse\Support\CpfCnpjFormatter;
```

## Métodos Disponíveis

### formatCpf()

Formata um CPF no padrão brasileiro (XXX.XXX.XXX-XX).

```php
echo CpfCnpjFormatter::formatCpf('12345678901');
// Saída: 123.456.789-01
```

**Assinatura:**

```php
public static function formatCpf(string $cpf): string
```

**Parâmetros:**

-   `$cpf` (string) - CPF sem formatação, contendo apenas números

**Retorno:**

-   (string) CPF formatado no padrão XXX.XXX.XXX-XX

**Exemplo:**

```php
$cpfBanco = '12345678901';
$cpfExibicao = CpfCnpjFormatter::formatCpf($cpfBanco);

echo $cpfExibicao; // 123.456.789-01
```

---

### formatCnpj()

Formata um CNPJ no padrão brasileiro (XX.XXX.XXX/XXXX-XX).

```php
echo CpfCnpjFormatter::formatCnpj('12345678000199');
// Saída: 12.345.678/0001-99
```

**Assinatura:**

```php
public static function formatCnpj(string $cnpj): string
```

**Parâmetros:**

-   `$cnpj` (string) - CNPJ sem formatação, contendo apenas números

**Retorno:**

-   (string) CNPJ formatado no padrão XX.XXX.XXX/XXXX-XX

**Exemplo:**

```php
$cnpjBanco = '12345678000199';
$cnpjExibicao = CpfCnpjFormatter::formatCnpj($cnpjBanco);

echo $cnpjExibicao; // 12.345.678/0001-99
```

---

### formatCep()

Formata um CEP no padrão brasileiro (XXXXX-XXX).

```php
echo CpfCnpjFormatter::formatCep('12345678');
// Saída: 12345-678
```

**Assinatura:**

```php
public static function formatCep(string $cep): string
```

**Parâmetros:**

-   `$cep` (string) - CEP sem formatação, contendo apenas números

**Retorno:**

-   (string) CEP formatado no padrão XXXXX-XXX

**Exemplo:**

```php
$cepBanco = '01310100';
$cepExibicao = CpfCnpjFormatter::formatCep($cepBanco);

echo $cepExibicao; // 01310-100
```

---

### unformat()

Remove toda a formatação de um documento, mantendo apenas os números.

```php
echo CpfCnpjFormatter::unformat('123.456.789-01');
// Saída: 12345678901
```

**Assinatura:**

```php
public static function unformat(string $value): string
```

**Parâmetros:**

-   `$value` (string) - Valor formatado (CPF, CNPJ, CEP, etc.)

**Retorno:**

-   (string) Apenas os dígitos numéricos

**Exemplos:**

```php
// CPF
echo CpfCnpjFormatter::unformat('123.456.789-01');
// 12345678901

// CNPJ
echo CpfCnpjFormatter::unformat('12.345.678/0001-99');
// 12345678000199

// CEP
echo CpfCnpjFormatter::unformat('12345-678');
// 12345678

// Qualquer string com números
echo CpfCnpjFormatter::unformat('ABC-123.456/789');
// 123456789
```

---

## Casos de Uso

### 1. Exibição em Views

```php
// Controller
$cliente = Cliente::find(1);

// View
<p>CPF: {{ CpfCnpjFormatter::formatCpf($cliente->cpf) }}</p>
<p>CNPJ: {{ CpfCnpjFormatter::formatCnpj($empresa->cnpj) }}</p>
```

### 2. Normalização antes de Salvar

```php
use Nfse\Support\CpfCnpjFormatter;

// Recebe do formulário (pode vir formatado)
$cpf = $request->input('cpf'); // "123.456.789-01"

// Remove formatação antes de salvar
$cliente->cpf = CpfCnpjFormatter::unformat($cpf); // "12345678901"
$cliente->save();
```

### 3. API Response Formatting

```php
return response()->json([
    'cliente' => [
        'nome' => $cliente->nome,
        'cpf' => CpfCnpjFormatter::formatCpf($cliente->cpf),
        'endereco' => [
            'cep' => CpfCnpjFormatter::formatCep($cliente->cep),
            // ...
        ]
    ]
]);
```

### 4. Preparação para XML

```php
use Nfse\Support\CpfCnpjFormatter;

// Garantir que o documento está sem formatação
$tomadorData = new TomadorData(
    cpf: CpfCnpjFormatter::unformat($request->cpf),
    cnpj: null,
    // ...
);
```

### 5. Validação Condicional

```php
$documento = $request->input('documento');
$documentoLimpo = CpfCnpjFormatter::unformat($documento);

if (strlen($documentoLimpo) === 11) {
    // É CPF
    $cpfFormatado = CpfCnpjFormatter::formatCpf($documentoLimpo);
} elseif (strlen($documentoLimpo) === 14) {
    // É CNPJ
    $cnpjFormatado = CpfCnpjFormatter::formatCnpj($documentoLimpo);
}
```

---

## 💡 Boas Práticas

### ✅ Recomendado

```php
// Sempre armazene sem formatação no banco
$cliente->cpf = CpfCnpjFormatter::unformat($request->cpf);

// Formate apenas para exibição
$cpfExibicao = CpfCnpjFormatter::formatCpf($cliente->cpf);
```

### ❌ Evite

```php
// Não armazene formatado no banco
$cliente->cpf = CpfCnpjFormatter::formatCpf($request->cpf); // ❌

// Não use formatação em comparações
if ($cpf === '123.456.789-01') { // ❌
    // ...
}

// Use sem formatação
if (CpfCnpjFormatter::unformat($cpf) === '12345678901') { // ✅
    // ...
}
```

---

## Integração com Validação Laravel

```php
use Illuminate\Validation\Rule;
use Nfse\Support\CpfCnpjFormatter;

// No FormRequest
public function prepareForValidation()
{
    $this->merge([
        'cpf' => CpfCnpjFormatter::unformat($this->cpf),
        'cnpj' => CpfCnpjFormatter::unformat($this->cnpj),
        'cep' => CpfCnpjFormatter::unformat($this->cep),
    ]);
}

public function rules()
{
    return [
        'cpf' => ['required', 'cpf'], // Validação já recebe sem formatação
        'cnpj' => ['nullable', 'cnpj'],
        'cep' => ['required', 'regex:/^\d{8}$/'],
    ];
}
```

---

## Notas Técnicas

-   **Performance:** Todos os métodos são estáticos e não mantêm estado, sendo extremamente rápidos.
-   **Validação:** Esta classe **não valida** se o CPF/CNPJ é válido, apenas formata. Use validadores específicos para isso.
-   **Encoding:** Funciona com strings UTF-8 sem problemas.
-   **Null Safety:** Não aceita valores `null`. Certifique-se de passar strings válidas.

---

## 🔗 Veja Também

-   [TaxCalculator](./tax-calculator) - Cálculos tributários
-   [IdGenerator](./id-generator) - Geração de IDs únicos
-   [CpfCnpjGenerator](./cpf-cnpj-generator) - Geração de documentos para testes
