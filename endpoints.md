Endpoints customizados por município

Este documento lista os municípios que utilizam endpoints próprios para integração com a NFS-e, mesmo seguindo o padrão nacional.

Como funciona

O pacote possui 3 tipos de configuração de endpoint:

1. Endpoint padrão nacional

Quando o município não possui um endpoint específico mapeado, o pacote utiliza os endereços padrão da NFS-e nacional:

```
private const DEFAULT = [
    'production' => 'https://sefin.nfse.gov.br/SefinNacional',
    'homologation' => 'https://sefin.producaorestrita.nfse.gov.br/SefinNacional',
];
```

2. Endpoints específicos por município

Alguns municípios adotam o mesmo padrão da NFS-e nacional, porém disponibilizam a integração em URLs próprias. Nestes casos, o pacote utiliza um mapeamento por código IBGE:

```
private const ENDPOINTS = [
    '3511102' => [
        'production' => 'https://164.152.60.237/nota/nacional',
        'homologation' => 'https://catanduva.prefeitura.rlz.com.br/nota/nacional',
    ],
];
```

3. Endpoints customizado

```php
use Nfse\Http\NfseContext;
use Nfse\Dto\Http\Endpoint;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    ambiente: TipoAmbiente::Producao,
    certificatePath: '/path/to/cert.pfx',
    certificatePassword: 'password',
    endpoint: new Endpoint([
        'production'   => 'https://164.152.60.237/nota/nacional',
        'homologation' => 'https://catanduva.prefeitura.rlz.com.br/nota/nacional',
    ])
);
```

Lista de municípios homologados

Código IBGE	Município	Produção	Homologação
3511102	Catanduva/SP	https://164.152.60.237/nota/nacional	https://catanduva.prefeitura.rlz.com.br/nota/nacional

Observações
	•	A constante ENDPOINTS foi projetada para receber vários municípios, conforme novas prefeituras homologadas forem identificadas.
	•	Sempre que existir um mapeamento específico para o código IBGE do município, ele terá prioridade sobre o endpoint padrão definido em DEFAULT.
	•	Caso o município não esteja listado em ENDPOINTS, o pacote utilizará automaticamente os endpoints nacionais padrão.
	•	Esta abordagem permite compatibilidade com prefeituras que seguem o layout nacional, mas operam em infraestrutura própria.

Objetivo deste mapeamento

Este recurso foi adicionado para ampliar a compatibilidade do pacote com municípios que:
	•	seguem o padrão nacional da NFS-e;
	•	exigem comunicação por URL própria;
	•	não respondem corretamente pelos endpoints nacionais padrão.

Expansão futura

Conforme novas cidades forem homologadas, elas poderão ser adicionadas à constante ENDPOINTS e também documentadas neste arquivo para facilitar a manutenção e consulta pela comunidade.
Se precisar incluir uma cidade, abra uma nova issue com a sua solicitação que em breve adicionaremos ao projeto.