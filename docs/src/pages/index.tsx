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

import styles from "./index.module.css";

function HomepageHeader() {
    const { siteConfig } = useDocusaurusContext();
    return (
        <header className={clsx("hero hero--primary", styles.heroBanner)}>
            <div className="container">
                <Heading as="h1" className="hero__title">
                    {siteConfig.title}
                </Heading>
                <p className="hero__subtitle">{siteConfig.tagline}</p>
                <p className={styles.heroDescription}>
                    Este pacote fornece um conjunto robusto de DTOs que
                    simplificam a criação e validação dos XMLs, oferecendo uma
                    interface fluida e uma documentação alinhada à realidade do
                    desenvolvedor.
                </p>
                <div className={styles.buttons}>
                    <Link
                        className="button button--secondary button--lg"
                        to="/docs/overview"
                    >
                        Começar Agora 🚀
                    </Link>
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
            title={`Hello from ${siteConfig.title}`}
            description="Description will go into a meta tag in <head />"
        >
            <HomepageHeader />
            <main>
                <HomepageFeatures />
                <DtoAdvantages />
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
