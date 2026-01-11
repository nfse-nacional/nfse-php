                                                # Estrutura Hierárquica dos DTOs

## Hierarquia XML → Namespaces

Os DTOs gerados seguem exatamente a hierarquia do XML:

```
NFSe (raiz)
└── infNFSe
    ├── emit (Emitente)
    │   └── enderNac (EnderecoNacional)
    ├── valores (ValoresNFSe)
    └── DPS
        └── infDPS
            ├── subst (Substituicao)
            ├── prest (Prestador)
            │   ├── end (Endereco)
            │   │   ├── endNac (EnderecoNacional)
            │   │   └── endExt (EnderecoExterior)
            │   └── regTrib (RegimeTributario)
            ├── toma (Tomador)
            │   └── end (Endereco)
            ├── interm (Intermediario)
            ├── serv (Servico)
            │   ├── locPrest (LocalPrestacao)
            │   ├── cServ (CodigoServico)
            │   ├── comExt (ComercioExterior)
            │   ├── obra (Obra)
            │   └── atvEvento (AtividadeEvento)
            └── valores (Valores)
                ├── vServPrest (ValorServicoPrestado)
                ├── vDescCondIncond (DescontoCondicionadoIncondicionado)
                ├── vDedRed (DeducaoReducao)
                └── trib (Tributacao)
                    ├── tribMun (TributacaoMunicipal)
                    └── tribFed (TributacaoFederal)
```

## Mapeamento de Namespaces

### Versão 1.0.0

```
XML Path                                    → Namespace
─────────────────────────────────────────────────────────────────────────────
NFSe                                        → Nfse\Dto\V1_0_0
NFSe/infNFSe                               → Nfse\Dto\V1_0_0\NFSe
NFSe/infNFSe/emit                          → Nfse\Dto\V1_0_0\NFSe\InfNFSe
NFSe/infNFSe/DPS                           → Nfse\Dto\V1_0_0\NFSe\InfNFSe
NFSe/infNFSe/DPS/infDPS                    → Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS
NFSe/infNFSe/DPS/infDPS/prest              → Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS
NFSe/infNFSe/DPS/infDPS/prest/end          → Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Prestador
NFSe/infNFSe/DPS/infDPS/valores            → Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS
NFSe/infNFSe/DPS/infDPS/valores/trib       → Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Valores
```

## Estrutura de Diretórios

```
src/Dto/
└── V1_0_0/                                 # Versão 1.0.0
    ├── NFSe/                               # Raiz NFSe
    │   ├── NFSeData.php
    │   └── InfNFSe/                        # infNFSe
    │       ├── InfNFSeData.php
    │       ├── Emitente/                   # emit
    │       │   ├── EmitenteData.php
    │       │   └── EnderecoNacional/
    │       ├── Valores/                    # valores da NFSe
    │       │   └── ValoresNFSeData.php
    │       └── DPS/                        # DPS
    │           ├── DPSData.php
    │           └── InfDPS/                 # infDPS
    │               ├── InfDPSData.php
    │               ├── Substituicao/
    │               ├── Prestador/          # prest
    │               │   ├── PrestadorData.php
    │               │   └── Endereco/
    │               ├── Tomador/            # toma
    │               ├── Intermediario/      # interm
    │               ├── Servico/            # serv
    │               └── Valores/            # valores do DPS
    │                   ├── ValoresData.php
    │                   └── Tributacao/
    └── Evento/                             # Eventos
        ├── EventoData.php
        └── PedRegEvento/
```

## Exemplo de Uso

```php
use Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\CInfoPrestadorData;
use Nfse\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Prestador\CEnderecoData;

// A hierarquia do namespace reflete a hierarquia XML
$prestador = \map(CInfoPrestadorData::class, [
    'CNPJ' => '12345678000199',
    'xNome' => 'Empresa Teste',
    'end' => [
        'endNac' => [
            'cMun' => '3550308',
            'CEP' => '01310100',
        ]
    ]
]);
```

## Benefícios da Estrutura Hierárquica

1. **Clareza**: A estrutura de pastas reflete exatamente o XML
2. **Navegação**: Fácil encontrar DTOs seguindo o caminho XML
3. **Organização**: Agrupamento lógico por contexto
4. **Manutenção**: Mudanças no schema são refletidas na estrutura
5. **Documentação**: A estrutura é auto-documentada
