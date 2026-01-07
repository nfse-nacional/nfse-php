import type { ReactNode } from "react";
import clsx from "clsx";
import Link from "@docusaurus/Link";
import useDocusaurusContext from "@docusaurus/useDocusaurusContext";
import Layout from "@theme/Layout";
import HomepageFeatures from "@site/src/components/HomepageFeatures";
import DtoAdvantages from "@site/src/components/DtoAdvantages";
import RoadmapStepper from "@site/src/components/RoadmapStepper";
import FAQ from "@site/src/components/FAQ";
import Heading from "@theme/Heading";
import Tabs from "@theme/Tabs";
import TabItem from "@theme/TabItem";

import styles from "./index.module.css";

import CodeBlock from "@theme/CodeBlock";
import SdkPowers from "@site/src/components/SdkPowers";

function HomepageHeader() {
    const { siteConfig } = useDocusaurusContext();
    return (
        <header className={clsx("hero hero--primary", styles.heroBanner)}>
            <div className={styles.heroContainer}>
                <div>
                    <Heading as="h1" className="hero__title">
                        {siteConfig.title}
                    </Heading>
                    <p className="hero__subtitle">{siteConfig.tagline}</p>
                    <p className="hero__subtitle">
                        Suporte completo às APIs de{" "}
                        <strong>Contribuinte</strong> (empresas) e{" "}
                        <strong>Município</strong> (prefeituras).
                    </p>
                    <p className={styles.heroDescription}>
                        Emita, consulte e cancele notas fiscais de serviço (API
                        Contribuinte) ou gerencie documentos fiscais do seu
                        município (API Município) — tudo com validação
                        automática de DTOs, assinatura digital integrada e
                        tipagem completa.
                    </p>
                    <div
                        className="alert alert--warning margin-bottom--md"
                        role="alert"
                        style={{ textAlign: "left" }}
                    >
                        <div className="admonition-heading">
                            <h5>⚠️ Adequação dos Municípios</h5>
                        </div>
                        <div className="admonition-content">
                            <p style={{ marginBottom: 0 }}>
                                Os municípios ainda estão em processo de
                                adequação. Verifique o status no{" "}
                                <Link to="https://app.powerbi.com/view?r=eyJrIjoiNGQ4YTcxNmMtMzdhNC00Mzc5LTllM2EtMjY1MTM3NWQyZDgyIiwidCI6IjZmNDlhYTQzLTgyMmEtNGMyMC05NjcwLWRiNzcwMGJmMWViMCJ9&pageName=608609c2e0a53d7a3c6e">
                                    PowerBI
                                </Link>{" "}
                                e consulte o convênio via API (veja exemplo no{" "}
                                <Link to="https://github.com/nfse-nacional/nfse-php/blob/main/examples/contribuinte/parametros/consultar_parametros.php">
                                    GitHub
                                </Link>
                                ).
                            </p>
                        </div>
                    </div>
                    <div className={styles.buttons}>
                        <Link
                            className="button button--secondary button--lg"
                            to="/docs/quickstart"
                        >
                            Começar Agora 🚀
                        </Link>
                    </div>
                </div>
                <div className={styles.codeBlockContainer}>
                    <div className={styles.codeHeader}>
                        <span
                            className={clsx(styles.dot, styles.dotRed)}
                        ></span>
                        <span
                            className={clsx(styles.dot, styles.dotYellow)}
                        ></span>
                        <span
                            className={clsx(styles.dot, styles.dotGreen)}
                        ></span>
                    </div>
                    <div className={styles.codeScroll}>
                        <div className={styles.tabsDense}>
                            <Tabs>
                                <TabItem
                                    value="array"
                                    label="Array (Padrão Nacional)"
                                    default
                                >
                                    <CodeBlock language="php">
                                        {`use Nfse\\Dto\\Nfse\\DpsData;
use Nfse\\Xml\\DpsXmlBuilder;
use Illuminate\\Validation\\ValidationException;

// 1. Dados vindos da sua aplicação (ex: $request->all())
$dadosDoFormulario = [
    '@attributes' => ['versao' => '1.00'],
    'infDPS' => [
        '@attributes' => ['Id' => 'DPS123456'],
        'tpAmb' => 2, // Homologação
        'dhEmi' => '2023-10-27T10:00:00',
        'verAplic' => '1.0',
        'serie' => '1',
        'nDPS' => '100',
        'dCompet' => '2023-10-27',
        'tpEmit' => 1,
        'cLocEmi' => '3550308',
        'prest' => [
            'CNPJ' => '12345678000199',
            'IM' => '12345',
            'xNome' => 'Minha Empresa Ltda'
        ],
        'toma' => [
            'CPF' => '11122233344',
            'xNome' => 'Cliente Exemplo'
        ],
        'serv' => [
            'cServ' => [
                'cTribNac' => '01.01',
                'xDescServ' => 'Desenvolvimento de Software'
            ]
        ],
        'valores' => [
            'vServPrest' => [
                'vServ' => 1000.00
            ],
            'trib' => [
                'tribMun' => [
                    'tribISSQN' => 1,
                    'tpRetISSQN' => 1
                ]
            ]
        ]
    ]
];

try {
    // 2. Validar e criar o DTO
    $dps = new DpsData($dadosDoFormulario);

    // 3. Gerar o XML
    $builder = new DpsXmlBuilder();
    $xml = $builder->build($dps);

    // 4. Resultado
    header('Content-Type: application/xml');
    echo $xml;

} catch (ValidationException $e) {
    print_r($e->errors());
}`}
                                    </CodeBlock>
                                </TabItem>
                                <TabItem value="emitir" label="Emitir NFS-e">
                                    <CodeBlock language="php">
                                        {`use Nfse\Http\NfseContext;
use Nfse\Nfse;
use Nfse\Enums\TipoAmbiente;
use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Dto\Nfse\ServicoData;
use Nfse\Dto\Nfse\ValoresData;

$context = new NfseContext(
    TipoAmbiente::Homologacao,
    '/path/to/certificate.pfx',
    'password'
);

// Obtenha o serviço de Contribuinte
$nfse = new Nfse($context);
$service = $nfse->contribuinte();

$dps = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        id: 'DPS123',
        tipoAmbiente: 2,
        prestador: new PrestadorData(cnpj: '12345678000199'),
        tomador: new TomadorData(cpf: '11122233344'),
        servico: new ServicoData(codigoTributacaoNacional: '01.01'),
        valores: new ValoresData(valorServicos: 100.00)
    )
);

$resultado = $service->emitir($dps);

if ($resultado instanceof \Nfse\Dto\Nfse\NfseData) {
    echo "Nota emitida: " . $resultado->infNfse->chaveAcesso;
} else {
    echo "Resposta não tipada — verifique o XML retornado.";
}`}
                                    </CodeBlock>
                                </TabItem>
                                <TabItem value="consultar" label="Consultar">
                                    <CodeBlock language="php">
                                        {`// 1. Instancie o serviço (igual ao exemplo anterior)
$nfse = new Nfse($context);
$service = $nfse->contribuinte();

// 2. Consulte pela chave de acesso
$chave = '12345678901234567890123456789012345678901234567890';
try {
    $nfse = $service->consultar($chave);
    if ($nfse instanceof \Nfse\Dto\Nfse\NfseData) {
        echo "Nota encontrada! Emitida em: " . $nfse->infNfse->dataEmissao;
    } else {
        echo "Nota não encontrada ou resposta não tipada.";
    }
} catch (\Exception $e) {
    echo "Erro na consulta: " . $e->getMessage();
}`}
                                    </CodeBlock>
                                </TabItem>
                                <TabItem
                                    value="eventos"
                                    label="Eventos (Cancelar)"
                                >
                                    <CodeBlock language="php">
                                        {`use Nfse\Signer\Certificate;
use Nfse\Signer\XmlSigner;
use Nfse\Dto\Nfse\CancelamentoData;
use Nfse\Dto\Nfse\InfPedRegData;
use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Xml\EventosXmlBuilder;

// Assumindo que $service foi instanciado conforme o exemplo de emissão
$infPedReg = new InfPedRegData(id: 'e1', identidadeEmitente: '12345678000199', cpfAutor: '11122233344');
$cancel = new CancelamentoData(motivo: 'Erro na emissão');
$ped = new PedRegEventoData(versao: '1.01', infPedReg: $infPedReg, eventos: [$cancel]);

$xml = (new EventosXmlBuilder())->build($ped);

$cert = new Certificate('/path/to/cert.pfx', 'password');
$signer = new XmlSigner($cert);
$signed = $signer->sign($xml, 'pedRegEvento');
$payload = base64_encode(gzencode($signed));

$chave = '12345678901234567890123456789012345678901234567890';
$resultado = $service->registrarEvento($chave, $payload);
if ($resultado->sucesso ?? false) {
    echo "Evento registrado com sucesso!";
}`}
                                    </CodeBlock>
                                </TabItem>
                                <TabItem
                                    value="semantic"
                                    label="Objeto (Explícito)"
                                >
                                    <CodeBlock language="php">
                                        {`use Nfse\\Dto\\Nfse\\DpsData;
use Nfse\\Dto\\Nfse\\InfDpsData;
use Nfse\\Dto\\Nfse\\PrestadorData;
use Nfse\\Dto\\Nfse\\TomadorData;
use Nfse\\Dto\\Nfse\\ServicoData;
use Nfse\\Dto\\Nfse\\ValoresData;
use Nfse\\Xml\\DpsXmlBuilder;

// Construção Semântica com Argumentos Nomeados (PHP 8+)
// Você sabe exatamente o que cada campo significa
$dps = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        id: 'DPS123456',
        tipoAmbiente: 2, // Homologação
        dataEmissao: '2023-10-27T10:00:00',
        versaoAplicativo: '1.0',
        serie: '1',
        numeroDps: '100',
        dataCompetencia: '2023-10-27',
        tipoEmitente: 1, // Prestador
        codigoLocalEmissao: '3550308',
        prestador: new PrestadorData(
            cnpj: '12345678000199',
            inscricaoMunicipal: '12345',
            nomeFantasia: 'Minha Empresa Ltda'
        ),
        tomador: new TomadorData(
            cpf: '11122233344',
            nome: 'Cliente Exemplo'
        ),
        servico: new ServicoData(
            codigoTributacaoNacional: '01.01',
            descricao: 'Desenvolvimento de Software'
        ),
        valores: new ValoresData(
            valorServicos: 1000.00,
            tributacaoMunicipal: [ // Exemplo simplificado
                'tribISSQN' => 1,
                'tpRetISSQN' => 1
            ]
        ),
        // Campos opcionais podem ser omitidos ou passados como null
        motivoEmissaoTomadorIntermediario: null,
        chaveNfseRejeitada: null,
        substituicao: null,
        intermediario: null
    )
);

// Gerar o XML
$builder = new DpsXmlBuilder();
$xml = $builder->build($dps);

echo $xml;`}
                                    </CodeBlock>
                                </TabItem>
                            </Tabs>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    );
}

import React, { useState, useEffect } from "react";

export default function Home(): ReactNode {
    const { siteConfig } = useDocusaurusContext();
    const [isVisible, setIsVisible] = useState(true);

    useEffect(() => {
        const bannerDismissed = localStorage.getItem("dev-banner-dismissed");
        if (bannerDismissed === "true") {
            setIsVisible(false);
        }
    }, []);

    const handleClose = () => {
        setIsVisible(false);
        localStorage.setItem("dev-banner-dismissed", "true");
    };

    return (
        <Layout
            title={siteConfig.title}
            description="Description will go into a meta tag in <head />"
        >
            <HomepageHeader />
            <main>
                <HomepageFeatures />
                <DtoAdvantages />
                <SdkPowers />
                <RoadmapStepper />
                <FAQ />
            </main>
            {isVisible && (
                <div className="devBanner">
                    <span className="devBanner__text">
                        🚧 Este projeto está em{" "}
                        <strong>desenvolvimento ativo</strong>. Algumas
                        funcionalidades podem estar incompletas ou sujeitas a
                        alterações.
                    </span>
                    <button
                        className="devBanner__close"
                        onClick={handleClose}
                        aria-label="Fechar"
                    >
                        &times;
                    </button>
                </div>
            )}
        </Layout>
    );
}
