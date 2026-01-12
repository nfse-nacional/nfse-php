import type { ReactNode } from "react";
import clsx from "clsx";
import Link from "@docusaurus/Link";
import useDocusaurusContext from "@docusaurus/useDocusaurusContext";
import Layout from "@theme/Layout";
import Heading from "@theme/Heading";
import CodeBlock from "@theme/CodeBlock";

import styles from "./index.module.css";

function HomepageHeader() {
    const { siteConfig } = useDocusaurusContext();
    return (
        <header className={clsx("hero hero--primary", styles.heroBanner)}>
            <div className="container">
                <div
                    style={{
                        maxWidth: "800px",
                        margin: "0 auto",
                        textAlign: "center",
                    }}
                >
                    <Heading as="h1" className="hero__title">
                        {siteConfig.title}
                    </Heading>

                    <p
                        className="margin-bottom--xl"
                        style={{ fontSize: "1.25rem", padding: "0 1rem" }}
                    >
                        Uma biblioteca robusta e agnóstica para emissão de notas
                        (Contribuinte) e gestão fiscal (Município), construída
                        sobre a nova API Nacional.
                    </p>

                    <div className={styles.buttons}>
                        <Link
                            className="button button--secondary button--lg"
                            to="/docs/quickstart"
                        >
                            Começar Agora 🚀
                        </Link>
                        <Link
                            className="button button--outline button--secondary button--lg margin-left--md"
                            to="https://github.com/nfse-nacional/nfse-php"
                        >
                            Ver no GitHub
                        </Link>
                    </div>
                </div>
            </div>
        </header>
    );
}

export default function Home(): ReactNode {
    const { siteConfig } = useDocusaurusContext();

    return (
        <Layout
            title={siteConfig.title}
            description="Integração PHP moderna para a NFS-e Nacional"
        >
            <HomepageHeader />
            <main>
                <div className="container padding-vert--xl">
                    <div style={{ maxWidth: "800px", margin: "0 auto" }}>
                        <Heading
                            as="h3"
                            className="text--center margin-bottom--md"
                        >
                            Exemplo Rápido: Emitindo uma Nota (DPS)
                        </Heading>
                        <CodeBlock language="php">
                            {`use Nfse\\Dto\\Nfse\\DpsData;
use Nfse\\Support\\IdGenerator;

// 1. Gere o ID único
$id = IdGenerator::generateDpsId('CNPJ_TRESTADOR', 'COD_MUN', 'SERIE', 'NUMERO');

// 2. Crie o objeto DPS
$dps = new DpsData([
    '@attributes' => ['versao' => '1.00'],
    'infDPS' => [
        '@attributes' => ['Id' => $id],
        'tpAmb' => 2,
        'dhEmi' => date('Y-m-d\\TH:i:s'),
        'verAplic' => 'App 1.0',
        'serie' => '1',
        'nDPS' => '1001',
        'dCompet' => date('Y-m-d'),
        'tpEmit' => 1,
        'cLocEmi' => '3550308', // São Paulo
        'prest' => ['CNPJ' => '12345678000199'],
        'toma' => [
            'CPF' => '11122233344',
            'xNome' => 'Tomador de Exemplo'
        ],
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '01.01',
                'xDescServ' => 'Descrição do Serviço'
            ]
        ],
        'valores' => [
            'vServPrest' => [
                'vReceb' => 100.00,
                'vServ' => 100.00
            ],
            'trib' => [
                'tribMun' => [
                    'tribISSQN' => 1,
                    'tpRetISSQN' => 2, // Sem retenção
                    'pAliq' => 5.00
                ]
            ]
        ]
    ]
]);

// 3. Envie
try {
    $nfseData = $contribuinte->emitir($dps);
    echo "Sucesso! Nota emitida: " . $nfseData->infNfse->numeroNfse;
} catch (\\Exception $e) {
    echo "Erro: " . $e->getMessage();
}`}
                        </CodeBlock>
                        <div className="text--center margin-top--md">
                            <Link to="https://github.com/nfse-nacional/nfse-php/tree/main/examples">
                                Ver mais exemplos no GitHub →
                            </Link>
                        </div>
                    </div>
                </div>
            </main>
        </Layout>
    );
}
