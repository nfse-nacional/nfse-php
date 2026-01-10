# Serviço e Localização

Estes DTOs detalham o que foi prestado, onde ocorreu a prestação e como o serviço é classificado.

## ServicoData

Agrupa todas as informações relativas ao serviço prestado.

### Propriedades

| Propriedade             | Tipo                   | Mapeamento XML | Descrição                                      |
| :---------------------- | :--------------------- | :------------- | :--------------------------------------------- |
| `localPrestacao`        | `LocalPrestacaoData`   | `locPrest`     | Onde o serviço foi prestado.                   |
| `codigoServico`         | `CodigoServicoData`    | `cServ`        | Classificação e descrição do serviço.          |
| `comercioExterior`      | `ComercioExteriorData` | `comExt`       | Dados de comércio exterior (se aplicável).     |
| `obra`                  | `ObraData`             | `obra`         | Dados da obra (se aplicável).                  |
| `atividadeEvento`       | `AtividadeEventoData`  | `atvEvento`    | Dados do evento (se aplicável).                |
| `informacaoComplemento` | `InfoComplData`        | `infoCompl`    | Grupo de informações complementares do serviço |

#### Campos internos de `informacaoComplemento`

| Campo interno               | Tipo     | Mapeamento XML | Descrição                           |
| :-------------------------- | :------- | :------------- | :---------------------------------- |
| `idDocumentoTecnico`        | `string` | `idDocTec`     | Identificador do documento técnico. |
| `documentoReferencia`       | `string` | `docRef`       | Documento de referência.            |
| `informacoesComplementares` | `string` | `xInfComp`     | Observações gerais sobre o serviço. |

---

## LocalPrestacaoData

Identifica a localidade geográfica da prestação.

### Propriedades

| Propriedade            | Tipo     | Mapeamento XML   | Descrição                                       |
| :--------------------- | :------- | :--------------- | :---------------------------------------------- |
| `codigoLocalPrestacao` | `string` | `cLocPrestacao`  | Código IBGE do município (ou 0000000 para mar). |
| `codigoPaisPrestacao`  | `string` | `cPaisPrestacao` | Código ISO2 do país (se exterior).              |

---

## CodigoServicoData

Define a classificação fiscal do serviço.

### Propriedades

| Propriedade                 | Tipo     | Mapeamento XML | Descrição                            |
| :-------------------------- | :------- | :------------- | :----------------------------------- |
| `codigoTributacaoNacional`  | `string` | `cTribNac`     | Código da LC 116/03 (ex: 01.01).     |
| `codigoTributacaoMunicipal` | `string` | `cTribMun`     | Código do serviço no município.      |
| `descricaoServico`          | `string` | `xDescServ`    | Descrição detalhada do serviço.      |
| `codigoNbs`                 | `string` | `cNBS`         | Nomenclatura Brasileira de Serviços. |
| `codigoInternoContribuinte` | `string` | `cIntContrib`  | Código interno do serviço.           |

---

## EnderecoData

Estrutura universal para endereços na biblioteca.

### Propriedades

| Propriedade        | Tipo                   | Mapeamento XML | Descrição                               |
| :----------------- | :--------------------- | :------------- | :-------------------------------------- |
| `logradouro`       | `string`               | `xLgr`         | Nome da rua, avenida, etc.              |
| `numero`           | `string`               | `nro`          | Número do endereço.                     |
| `bairro`           | `string`               | `xBairro`      | Bairro.                                 |
| `complemento`      | `string`               | `xCpl`         | Complemento.                            |
| `codigoMunicipio`  | `string`               | `endNac.cMun`  | Código IBGE do município.               |
| `cep`              | `string`               | `endNac.CEP`   | CEP (8 dígitos).                        |
| `enderecoExterior` | `EnderecoExteriorData` | `endExt`       | Dados se o endereço for fora do Brasil. |

---

## EnderecoExteriorData

Estrutura para endereços no exterior.

### Propriedades

| Propriedade        | Tipo     | Mapeamento XML | Descrição                      |
| :----------------- | :------- | :------------- | :----------------------------- |
| `codigoPais`       | `string` | `cPais`        | Código ISO2 do país.           |
| `enderecoCompleto` | `string` | `endCompleto`  | Endereço completo no exterior. |
