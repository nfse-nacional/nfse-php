# 📦 Documentação dos DTOs

Esta página reúne a descrição completa de todos os **Data Transfer Objects (DTOs)** usados pelo SDK `nfse-php`. Cada seção contém:

-   **Nome da classe**
-   **Tabela de propriedades** (tipo, mapeamento XML e descrição)
-   **Observações** sobre uso ou relacionamentos.

---

## 1. `ServicoData`

| Propriedade             | Tipo                   | Mapeamento XML | Descrição                                      |
| :---------------------- | :--------------------- | :------------- | :--------------------------------------------- |
| `localPrestacao`        | `LocalPrestacaoData`   | `locPrest`     | Onde o serviço foi prestado.                   |
| `codigoServico`         | `CodigoServicoData`    | `cServ`        | Classificação e descrição do serviço.          |
| `comercioExterior`      | `ComercioExteriorData` | `comExt`       | Dados de comércio exterior (se aplicável).     |
| `obra`                  | `ObraData`             | `obra`         | Dados da obra (se aplicável).                  |
| `atividadeEvento`       | `AtividadeEventoData`  | `atvEvento`    | Dados do evento (se aplicável).                |
| `informacaoComplemento` | `InfoComplData`        | `infoCompl`    | Grupo de informações complementares do serviço |

---

## 2. `LocalPrestacaoData`

| Propriedade            | Tipo     | Mapeamento XML   | Descrição                                              |
| :--------------------- | :------- | :--------------- | :----------------------------------------------------- |
| `codigoLocalPrestacao` | `string` | `cLocPrestacao`  | Código IBGE do município (ou `0000000` para mar).      |
| `codigoPaisPrestacao`  | `string` | `cPaisPrestacao` | Código ISO 2 do país (quando o serviço é no exterior). |

---

## 3. `CodigoServicoData`

| Propriedade                 | Tipo     | Mapeamento XML | Descrição                            |
| :-------------------------- | :------- | :------------- | :----------------------------------- |
| `codigoTributacaoNacional`  | `string` | `cTribNac`     | Código da LC 116/03 (ex.: `01.01`).  |
| `codigoTributacaoMunicipal` | `string` | `cTribMun`     | Código do serviço no município.      |
| `descricaoServico`          | `string` | `xDescServ`    | Descrição detalhada do serviço.      |
| `codigoNbs`                 | `string` | `cNBS`         | Nomenclatura Brasileira de Serviços. |
| `codigoInternoContribuinte` | `string` | `cIntContrib`  | Código interno do serviço.           |

---

## 4. `ComercioExteriorData`

| Propriedade                    | Tipo                                | Mapeamento XML   | Descrição                                                                                                                    |
| :----------------------------- | :---------------------------------- | :--------------- | :--------------------------------------------------------------------------------------------------------------------------- |
| `modoPrestacao`                | `ModoPrestacao` (enum)              | `mdPrestacao`    | 1 – Transfronteiriço, 2 – Consumo no Brasil, 3 – Presença Comercial no Exterior, 4 – Movimento Temporário de Pessoas Físicas |
| `vinculoPrestacao`             | `int`                               | `vincPrest`      | 1 – Sem vínculo, 2 – Com vínculo                                                                                             |
| `tipoPessoaExportador`         | `TipoPessoa` (enum)                 | `tpPessoaExport` | 1 – PJ, 2 – PF                                                                                                               |
| `nifExportador`                | `string`                            | `NIFExport`      | NIF do exportador                                                                                                            |
| `codigoPaisExportador`         | `string`                            | `cPaisExport`    | Código do país do exportador                                                                                                 |
| `codigoMecanismoApoioFomento`  | `string`                            | `cMecAFComex`    | Código do mecanismo de apoio/fomento                                                                                         |
| `numeroEnquadramento`          | `string`                            | `nEnquad`        | Número do enquadramento                                                                                                      |
| `numeroProcesso`               | `string`                            | `nProc`          | Número do processo                                                                                                           |
| `indicadorIncentivo`           | `int`                               | `indIncentivo`   | 1 – Sim, 2 – Não                                                                                                             |
| `descricaoIncentivo`           | `string`                            | `xDescIncentivo` | Descrição do incentivo fiscal                                                                                                |
| `tipoMoeda`                    | `string`                            | `tpMoeda`        | Código ISO 4217 da moeda                                                                                                     |
| `valorServicoMoeda`            | `float`                             | `vServMoeda`     | Valor do serviço na moeda estrangeira                                                                                        |
| `mecanismoApoioComexPrestador` | `string`                            | `mecAFComexP`    | Mecanismo de apoio/fomento usado pelo prestador                                                                              |
| `mecanismoApoioComexTomador`   | `string`                            | `mecAFComexT`    | Mecanismo de apoio/fomento usado pelo tomador                                                                                |
| `movimentacaoTemporariaBens`   | `MovimentacaoTemporariaBens` (enum) | `movTempBens`    | Tipo de movimentação temporária de bens                                                                                      |
| `numeroDeclaracaoImportacao`   | `string`                            | `nDI`            | DI/DSI/DA/DRI‑E averbada                                                                                                     |
| `numeroRegistroExportacao`     | `string`                            | `nRE`            | Registro de Exportação averbado                                                                                              |
| `mdic`                         | `string`                            | `mdic`           | Compartilhamento de dados com o MDIC (1 – Sim, 2 – Não)                                                                      |

---

## 5. `ObraData`

| Propriedade                  | Tipo           | Mapeamento XML | Descrição                            |
| :--------------------------- | :------------- | :------------- | :----------------------------------- |
| `inscricaoImobiliariaFiscal` | `string`       | `inscImobFisc` | Inscrição imobiliária fiscal da obra |
| `codigoObra`                 | `string`       | `cObra`        | Código da obra                       |
| `endereco`                   | `EnderecoData` | `end`          | Endereço da obra                     |

---

## 6. `AtividadeEventoData`

| Propriedade         | Tipo           | Mapeamento XML | Descrição                         |
| :------------------ | :------------- | :------------- | :-------------------------------- |
| `nome`              | `string`       | `xNome`        | Nome da atividade ou evento       |
| `dataInicio`        | `string`       | `dtIni`        | Data de início (YYYY‑MM‑DD)       |
| `dataFim`           | `string`       | `dtFim`        | Data de término                   |
| `idAtividadeEvento` | `string`       | `idAtvEvt`     | Identificador da atividade/evento |
| `endereco`          | `EnderecoData` | `end`          | Endereço (opcional)               |

---

## 7. `InfoComplData` (grupo `infoCompl`)

| Campo interno               | Tipo     | Mapeamento XML | Descrição                                                |
| :-------------------------- | :------- | :------------- | :------------------------------------------------------- |
| `idDocumentoTecnico`        | `string` | `idDocTec`     | Identificador do documento técnico (ART, RRT, DRT, etc.) |
| `documentoReferencia`       | `string` | `docRef`       | Documento de referência (nota, contrato, etc.)           |
| `informacoesComplementares` | `string` | `xInfComp`     | Campo livre para observações gerais sobre o serviço      |

---

## 8. `EnderecoData`

| Propriedade        | Tipo                   | Mapeamento XML | Descrição                              |
| :----------------- | :--------------------- | :------------- | :------------------------------------- |
| `logradouro`       | `string`               | `xLgr`         | Nome da rua, avenida, etc.             |
| `numero`           | `string`               | `nro`          | Número do endereço                     |
| `bairro`           | `string`               | `xBairro`      | Bairro                                 |
| `complemento`      | `string`               | `xCpl`         | Complemento                            |
| `codigoMunicipio`  | `string`               | `endNac.cMun`  | Código IBGE do município               |
| `cep`              | `string`               | `endNac.CEP`   | CEP (8 dígitos)                        |
| `enderecoExterior` | `EnderecoExteriorData` | `endExt`       | Dados se o endereço for fora do Brasil |

---

## 9. `EnderecoExteriorData`

| Propriedade        | Tipo     | Mapeamento XML | Descrição                     |
| :----------------- | :------- | :------------- | :---------------------------- |
| `codigoPais`       | `string` | `cPais`        | Código ISO 2 do país          |
| `enderecoCompleto` | `string` | `endCompleto`  | Endereço completo no exterior |

---

## Como usar esta documentação

-   Cada **DTO** pode ser instanciado passando um array associativo cujas chaves são exatamente os nomes das tags XML (ex.: `cLocPrestacao`, `idDocTec`).
-   Campos opcionais podem ser omitidos ou definidos como `null`.
-   Quando um DTO contém outro DTO (ex.: `ServicoData` → `InfoComplData`), o XML resultante cria um **grupo** (ex.: `<infoCompl>`) contendo os campos internos.
-   Consulte os testes em `tests/Unit/Dto` para exemplos de uso prático.

---

_Esta página será mantida atualizada conforme novos DTOs forem adicionados ao SDK._
