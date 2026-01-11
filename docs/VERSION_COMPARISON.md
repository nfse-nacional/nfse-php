# Comparação de Versões de DTOs

## Script de Comparação

O script `scripts/compare_dto_versions.php` permite comparar DTOs entre diferentes versões do schema NFSe.

### Uso

```bash
# Comparar versões 1.0.0 e 1.0.1
php scripts/compare_dto_versions.php 1.0.0 1.0.1

# Comparar versões específicas
php scripts/compare_dto_versions.php <versao1> <versao2>
```

### Saída

O script fornece:

1. **Estatísticas Gerais**

    - Total de arquivos em cada versão
    - Arquivos em comum
    - Arquivos únicos em cada versão

2. **Arquivos Novos**

    - Lista de DTOs adicionados na versão mais recente

3. **Arquivos Removidos**

    - Lista de DTOs que existiam na versão anterior mas foram removidos

4. **Arquivos Modificados**

    - Lista de DTOs que existem em ambas versões mas com diferenças
    - Detalhes das propriedades adicionadas/removidas

5. **Resumo Final**
    - Contagem total de mudanças

### Exemplo de Saída

```
🔍 Comparando DTOs entre versões 1.0.0 e 1.0.1

📊 Estatísticas:
  • Arquivos em v1.0.0: 24
  • Arquivos em v1.0.1: 121
  • Arquivos em comum: 24
  • Apenas em v1.0.0: 0
  • Apenas em v1.0.1: 97

✅ Arquivos NOVOS na v1.0.1:
  - NFSe/CInfoRefNFSeData.php
  - NFSe/Dto/V1_0_1/CBeneficioMunicipalData.php
  ...

📋 Detalhes das modificações:
  📄 NFSe/InfNFSe/DPS/InfDPS/CServData.php
    ✅ Adicionado: xNome
    ❌ Removido: desc

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
📌 RESUMO:
  • Total de DTOs em v1.0.0: 24
  • Total de DTOs em v1.0.1: 121
  • Novos DTOs: 97
  • DTOs removidos: 0
  • DTOs modificados: 24
  • DTOs sem alteração: 0
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

## Principais Diferenças entre v1.0.0 e v1.0.1

### Novos Recursos na v1.0.1

1. **IBS/CBS (Reforma Tributária)**

    - Novos DTOs para suporte à Reforma Tributária
    - `CRTCInfoIBSCBSData`, `CRTCValoresIBSCBSData`, etc.

2. **Informações Complementares Expandidas**

    - `xPed` - Pedido
    - `gItemPed` - Grupo de itens do pedido

3. **Eventos Aprimorados**

    - Novos tipos de eventos
    - Campos adicionais para eventos

4. **CNC (Cadastro Nacional de Contribuintes)**
    - Suporte completo a CNC
    - `CNCData`, `CInfoContribuinteCNCData`

### Campos Modificados

#### NFSe/InfNFSe/CInfNFSeData

-   ✅ Adicionado: `xOutInf` (Outras informações)
-   ✅ Adicionado: `IBSCBS` (Informações IBS/CBS)

#### NFSe/InfNFSe/DPS/CInfDPSData

-   ✅ Adicionado: `cMotivoEmisTI` (Motivo emissão TI)
-   ✅ Adicionado: `chNFSeRej` (Chave NFSe rejeitada)
-   ✅ Adicionado: `IBSCBS` (Informações IBS/CBS)

#### NFSe/InfNFSe/DPS/InfDPS/Serv/CAtvEventoData

-   ✅ Adicionado: `xNome` (Nome do evento)
-   ✅ Adicionado: `idAtvEvt` (ID atividade/evento)
-   ❌ Removido: `desc` (Descrição - renomeado)
-   ❌ Removido: `id` (ID - renomeado)

## Compatibilidade

### Migração de v1.0.0 para v1.0.1

A maioria dos DTOs é compatível, mas alguns campos foram renomeados:

```php
// v1.0.0
$atvEvento->desc = 'Descrição';
$atvEvento->id = 'EVT123';

// v1.0.1
$atvEvento->xNome = 'Descrição';
$atvEvento->idAtvEvt = 'EVT123';
```

### Novos Campos Opcionais

Os novos campos na v1.0.1 são geralmente opcionais, permitindo compatibilidade com dados existentes:

```php
// Código v1.0.0 continua funcionando
$infDps->tpAmb = '2';
$infDps->dhEmi = '2024-01-10T10:00:00';

// Novos campos opcionais na v1.0.1
$infDps->cMotivoEmisTI = '4'; // Opcional
$infDps->IBSCBS = [...];       // Opcional
```

## Recomendações

1. **Teste Gradual**: Teste a migração em ambiente de homologação primeiro
2. **Validação**: Use os validadores para garantir conformidade com a nova versão
3. **Backup**: Mantenha backups dos dados antes de migrar
4. **Documentação**: Consulte a documentação oficial da SEFIN para detalhes sobre novos campos
