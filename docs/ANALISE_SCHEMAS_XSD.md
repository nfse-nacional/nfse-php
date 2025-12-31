# Análise dos Schemas XSD - NFSe Nacional

## Resumo Executivo

Este documento apresenta uma análise detalhada dos schemas XSD oficiais da NFSe Nacional, identificando pontos importantes para melhorar nossa implementação.

## 1. Estrutura de Assinatura Digital

### 1.1 Assinatura no DPS vs NFSe

**Descoberta Importante:**

```xml
<!-- DPS - Assinatura OPCIONAL -->
<xs:complexType name="TCDPS">
  <xs:sequence>
    <xs:element name="infDPS" type="TCInfDPS"/>
    <xs:element ref="ds:Signature" minOccurs="0"/>  <!-- OPCIONAL -->
  </xs:sequence>
  <xs:attribute name="versao" type="TVerNFSe" use="required"/>
</xs:complexType>

<!-- NFSe - Assinatura OBRIGATÓRIA -->
<xs:complexType name="TCNFSe">
  <xs:sequence>
    <xs:element name="infNFSe" type="TCInfNFSe"/>
    <xs:element ref="ds:Signature"/>  <!-- OBRIGATÓRIO -->
  </xs:sequence>
  <xs:attribute name="versao" type="TVerNFSe" use="required"/>
</xs:complexType>
```

**Implicações:**

-   ✅ Nossa implementação está correta ao tornar a assinatura opcional no DPS
-   ✅ A assinatura é obrigatória apenas na NFSe (retorno da SEFIN)
-   ⚠️ Devemos validar isso nos nossos DTOs e validadores

### 1.2 Padrão XML-DSig

O schema importa o padrão oficial XML-DSig:

```xml
<xs:import namespace="http://www.w3.org/2000/09/xmldsig#"
           schemaLocation="xmldsig-core-schema.xsd"/>
```

**Elementos da Assinatura:**

-   `SignedInfo` - Informações assinadas (obrigatório)
-   `SignatureValue` - Valor da assinatura (obrigatório)
-   `KeyInfo` - Informações da chave (opcional, mas recomendado)
-   `Object` - Objetos adicionais (opcional)

## 2. Identificadores (IDs)

### 2.1 ID do DPS

```xml
<xs:simpleType name="TSIdDPS">
  <xs:documentation>
    Informar o identificador precedido do literal 'DPS'.
    A regra de formação do identificador de 45 posições da DPS é:
    "DPS" + Cód.Mun (7) + Tipo de Inscrição Federal (1) +
    Inscrição Federal (14 - CPF completar com 000 à esquerda) +
    Série DPS (5) + Núm. DPS (15)
  </xs:documentation>
  <xs:restriction base="xs:string">
    <xs:whiteSpace value="preserve"/>
    <xs:maxLength value="45"/>
    <xs:pattern value="DPS[0-9]{42}"/>
  </xs:restriction>
</xs:simpleType>
```

**Validações:**

-   ✅ Tamanho fixo: 45 caracteres
-   ✅ Formato: `DPS` + 42 dígitos numéricos
-   ✅ CPF deve ser completado com zeros à esquerda (14 posições)

**Ação:** Verificar se nosso `IdGenerator` está correto

### 2.2 ID da NFSe

```xml
<xs:simpleType name="TSIdNFSe">
  <xs:documentation>
    Informar o identificador precedido do literal 'NFS'.
    A regra de formação do identificador de 53 posições da NFS-e é:
    "NFS" + Cód.Mun.(7) + Amb.Ger.(1) + Tipo de Inscrição Federal(1) +
    Inscrição Federal(14) + No.NFS-e(13) + AnoMes Emis.(4) +
    Cód.Num.(9) + DV(1)
  </xs:documentation>
  <xs:restriction base="xs:string">
    <xs:whiteSpace value="preserve"/>
    <xs:maxLength value="53"/>
    <xs:pattern value="NFS[0-9]{50}"/>
  </xs:restriction>
</xs:simpleType>
```

## 3. Tipos de Dados Importantes

### 3.1 Versão

```xml
<xs:simpleType name="TVerNFSe">
  <xs:documentation>Tipo Versão da NF-e - 1.01</xs:documentation>
  <xs:restriction base="xs:string">
    <xs:whiteSpace value="preserve"/>
    <xs:pattern value="1\.01"/>
  </xs:restriction>
</xs:simpleType>
```

**Ação:** Garantir que sempre usamos `1.01` como versão

### 3.2 Data e Hora UTC

```xml
<xs:simpleType name="TSDateTimeUTC">
  <xs:documentation>
    Data e Hora, formato UTC (AAAA-MM-DDThh:mm:ssTZD, onde TZD = +hh:mm ou -hh:mm)
  </xs:documentation>
  <xs:restriction base="xs:string">
    <xs:whiteSpace value="preserve"/>
    <xs:pattern value="(((20(([02468][048])|([13579][26]))-02-29))|(20[0-9][0-9])-((((0[1-9])|(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))T(20|21|22|23|[0-1]\d):[0-5]\d:[0-5]\d([\-,\+](0[0-9]|10|11):00|([\+](12):00))"/>
  </xs:restriction>
</xs:simpleType>
```

**Validações:**

-   ✅ Formato: `AAAA-MM-DDThh:mm:ssTZD`
-   ✅ Timezone obrigatório
-   ✅ Validação de datas válidas (incluindo anos bissextos)

### 3.3 Série do DPS

```xml
<xs:simpleType name="TSSerieDPS">
  <xs:restriction base="xs:string">
    <xs:maxLength value="5"/>
    <xs:pattern value="^(?!0{1,5}$)\d{1,5}$"/>  <!-- NÃO pode ser só zeros -->
    <xs:whiteSpace value="preserve"/>
  </xs:restriction>
</xs:simpleType>
```

**Importante:** A série NÃO pode ser composta apenas de zeros!

### 3.4 CPF e CNPJ

```xml
<xs:simpleType name="TSCNPJ">
  <xs:restriction base="xs:string">
    <xs:whiteSpace value="preserve"/>
    <xs:maxLength value="14"/>
    <xs:pattern value="[0-9]{14}"/>
  </xs:restriction>
</xs:simpleType>

<xs:simpleType name="TSCPF">
  <xs:restriction base="xs:string">
    <xs:whiteSpace value="preserve"/>
    <xs:maxLength value="11"/>
    <xs:pattern value="[0-9]{11}"/>
  </xs:restriction>
</xs:simpleType>
```

**Validações:**

-   ✅ Apenas números (sem formatação)
-   ✅ Tamanho fixo
-   ⚠️ Não há validação de dígito verificador no schema

### 3.5 Strings com Restrições

```xml
<xs:simpleType name="TSString">
  <xs:documentation>Tipo string genérico</xs:documentation>
  <xs:restriction base="xs:string">
    <xs:whiteSpace value="preserve"/>
    <!-- Não pode começar ou terminar com espaço -->
    <xs:pattern value="[!-ÿ]{1}[ -ÿ]{0,}[!-ÿ]{1}|[!-ÿ]{1}"/>
  </xs:restriction>
</xs:simpleType>
```

**Importante:** Strings não podem começar ou terminar com espaços!

## 4. Enumerações Importantes

### 4.1 Tipo de Ambiente

```xml
<xs:simpleType name="TSTipoAmbiente">
  <xs:documentation>
    Tipos de ambiente do Sistema Nacional NFS-e:
    1 - Produção;
    2 - Homologação;
  </xs:documentation>
  <xs:enumeration value="1"/>
  <xs:enumeration value="2"/>
</xs:simpleType>
```

### 4.2 Emitente do DPS

```xml
<xs:simpleType name="TSEmitenteDPS">
  <xs:documentation>
    Emitente da DPS:
    1 - Prestador
    2 - Tomador
    3 - Intermediário
  </xs:documentation>
  <xs:enumeration value="1"/>
  <xs:enumeration value="2"/>
  <xs:enumeration value="3"/>
</xs:simpleType>
```

### 4.3 Processo de Emissão

```xml
<xs:simpleType name="TSProcEmissao">
  <xs:documentation>
    Processo de Emissão da DPS:
    1 - Emissão com aplicativo do contribuinte (via Web Service);
    2 - Emissão com aplicativo disponibilizado pelo fisco (Web);
    3 - Emissão com aplicativo disponibilizado pelo fisco (App);
  </xs:documentation>
  <xs:enumeration value="1"/>
  <xs:enumeration value="2"/>
  <xs:enumeration value="3"/>
</xs:simpleType>
```

## 5. Melhorias Sugeridas para Nossa Implementação

### 5.1 Validações Adicionais

1. **Série do DPS:**

    ```php
    // Adicionar validação para garantir que série não seja só zeros
    if (preg_match('/^0+$/', $serie)) {
        throw new ValidationException('Série não pode ser composta apenas de zeros');
    }
    ```

2. **Strings:**

    ```php
    // Remover espaços no início e fim
    $value = trim($value);

    // Validar que não está vazio após trim
    if (empty($value)) {
        throw new ValidationException('Valor não pode estar vazio');
    }
    ```

3. **Data/Hora UTC:**
    ```php
    // Garantir que sempre temos timezone
    $datetime = new DateTime($value);
    if (!$datetime->getTimezone()) {
        throw new ValidationException('Timezone é obrigatório');
    }
    ```

### 5.2 Constantes para Enumerações

Criar classes de constantes para os valores enumerados:

```php
class TipoAmbiente
{
    public const PRODUCAO = '1';
    public const HOMOLOGACAO = '2';
}

class EmitenteDPS
{
    public const PRESTADOR = '1';
    public const TOMADOR = '2';
    public const INTERMEDIARIO = '3';
}

class ProcessoEmissao
{
    public const WEB_SERVICE = '1';
    public const WEB_FISCO = '2';
    public const APP_FISCO = '3';
}
```

### 5.3 Validador de Schema XSD

Implementar validação contra o schema XSD oficial:

```php
class XsdValidator
{
    public function validate(string $xml, string $schemaPath): bool
    {
        $dom = new DOMDocument();
        $dom->loadXML($xml);

        return $dom->schemaValidate($schemaPath);
    }
}
```

### 5.4 Atributo `Id` nos Elementos

Garantir que o atributo `Id` está presente onde é obrigatório:

```xml
<!-- DPS -->
<infDPS Id="DPS330455721190597100010500333000000000000006">
  ...
</infDPS>

<!-- NFSe -->
<infNFSe Id="NFS33045572211905971000105000000000014625124504258429">
  ...
</infNFSe>
```

## 6. Checklist de Conformidade

### ✅ Já Implementado

-   [x] Estrutura básica de DTOs
-   [x] Geração de ID do DPS
-   [x] Assinatura digital XML-DSig
-   [x] Serialização para XML
-   [x] Validação básica de campos obrigatórios

### ⚠️ Precisa Revisão

-   [ ] Validação de série (não pode ser só zeros)
-   [ ] Validação de strings (trim automático)
-   [ ] Validação de timezone em datas
-   [ ] Constantes para enumerações
-   [ ] Validação contra XSD oficial

### 🔄 Melhorias Futuras

-   [ ] Validador XSD automático
-   [ ] Gerador de ID da NFSe
-   [ ] Validação de dígitos verificadores (CPF/CNPJ)
-   [ ] Sanitização automática de strings
-   [ ] Testes de conformidade com schemas

## 7. Referências

-   **Schemas Oficiais:** `/references/schemas/`
-   **XML-DSig Spec:** https://www.w3.org/TR/xmldsig-core/
-   **Manual NFSe Nacional:** https://www.gov.br/nfse/

## 8. Conclusão

Os schemas XSD fornecem especificações detalhadas que podem melhorar significativamente nossa implementação. As principais ações são:

1. ✅ **Assinatura opcional no DPS** - Nossa implementação está correta
2. ⚠️ **Validações adicionais** - Implementar validações de série, strings e datas
3. 🔄 **Constantes de enumeração** - Criar classes para valores enumerados
4. 🔄 **Validador XSD** - Implementar validação automática contra schemas

A análise dos schemas confirma que nossa arquitetura está no caminho certo, mas há oportunidades de melhorias nas validações e conformidade.
