import React from "react";
import clsx from "clsx";
import styles from "./styles.module.css";

interface Step {
    title: string;
    description: string;
    status: "completed" | "in-progress" | "pending";
}

const steps: Step[] = [
    {
        title: "Fase 1: Estrutura de Dados (DTOs) ✅",
        description:
            "DTOs tipados com spatie/laravel-data, mapeamento de campos, validações robustas e enums nativos PHP 8.1+.",
        status: "completed",
    },
    {
        title: "Fase 2: Serialização XML ✅",
        description:
            "Geração de XML (padrão Nacional NFSe) com DpsXmlBuilder e NfseXmlBuilder totalmente funcionais.",
        status: "completed",
    },
    {
        title: "Fase 3: Assinatura Digital ✅",
        description:
            "Suporte completo a certificados A1, XmlSigner parametrizado (SHA-1/SHA-256), validação de elemento raiz.",
        status: "completed",
    },
    {
        title: "Fase 4: Utilitários ✅",
        description:
            "IdGenerator (DPS/NFSe), CpfCnpjGenerator (CPF/CNPJ), validadores e helpers implementados.",
        status: "completed",
    },
    {
        title: "Fase 5: Documentação & Busca 🚀",
        description:
            "Docusaurus com busca local Spotlight-style, documentação completa de DTOs, assinatura e utilitários.",
        status: "in-progress",
    },
    {
        title: "Fase 6: Web Services (SDK) ✅",
        description:
            "Integração nativa com SEFIN Nacional e ADN: emissão, consulta, eventos e parâmetros municipais.",
        status: "completed",
    },
    {
        title: "Fase 7: Testes E2E & CI/CD",
        description:
            "Testes end-to-end com ambiente de homologação, GitHub Actions para CI/CD e releases automáticas.",
        status: "pending",
    },
];

export default function RoadmapStepper(): React.JSX.Element {
    return (
        <section className={styles.roadmapSection}>
            <div className="container">
                <h2 className={styles.roadmapTitle}>
                    Roadmap de Desenvolvimento
                </h2>
                <div className={styles.stepper}>
                    {steps.map((step, idx) => (
                        <div
                            key={idx}
                            className={clsx(styles.step, styles[step.status])}
                        >
                            <div className={styles.stepMarker}>
                                <div className={styles.stepCircle}>
                                    {step.status === "completed" && (
                                        <span className={styles.checkIcon}>
                                            ✓
                                        </span>
                                    )}
                                    {step.status === "in-progress" && (
                                        <div className={styles.pulse}></div>
                                    )}
                                </div>
                                {idx < steps.length - 1 && (
                                    <div className={styles.stepLine}></div>
                                )}
                            </div>
                            <div className={styles.stepContent}>
                                <h3 className={styles.stepTitle}>
                                    {step.title}
                                </h3>
                                <p className={styles.stepDescription}>
                                    {step.description}
                                </p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
