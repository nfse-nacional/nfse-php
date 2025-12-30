import React, { useState } from "react";
import clsx from "clsx";
import styles from "./styles.module.css";

type FAQItem = {
    question: string;
    answer: React.ReactNode;
};

const FAQList: FAQItem[] = [
    {
        question: "O que este pacote faz exatamente?",
        answer: (
            <>
                <p>
                    Este pacote atua como uma biblioteca de modelagem e
                    validação de dados para a NFS-e Nacional. Ele fornece:
                </p>
                <ul>
                    <li>
                        <strong>Geração de XML:</strong> Criação do XML final
                        compatível com o padrão nacional a partir de objetos
                        PHP.
                    </li>
                    <li>
                        <strong>Validação e Documentação:</strong> DTOs que
                        documentam cada propriedade e validam os dados
                        automaticamente antes da geração, prevenindo erros de
                        schema.
                    </li>
                    <li>
                        <strong>Segurança de Tipos:</strong> Garante que você
                        está passando os dados corretos (strings, inteiros,
                        datas) para os campos certos.
                    </li>
                </ul>
            </>
        ),
    },
    {
        question: "O que este pacote NÃO faz?",
        answer: (
            <>
                <p>
                    É importante alinhar expectativas. Este pacote{" "}
                    <strong>NÃO</strong> é:
                </p>
                <ul>
                    <li>
                        <strong>Um Cliente HTTP/SOAP:</strong> Ele não realiza a
                        transmissão (envio) da nota para a API da Receita. Seu
                        papel é entregar o XML pronto e validado para que sua
                        aplicação faça o envio.
                    </li>
                    <li>
                        Um software de gestão (ERP) completo com interface
                        gráfica.
                    </li>
                    <li>
                        Um consultor fiscal (sempre valide as regras tributárias
                        com seu contador).
                    </li>
                </ul>
            </>
        ),
    },
    {
        question: "Para quem este pacote é útil?",
        answer: (
            <p>
                É ideal para <strong>desenvolvedores PHP</strong> e empresas de
                software (Software Houses) que precisam integrar a emissão de
                NFS-e Nacional em seus sistemas (ERPs, PDVs, E-commerces) de
                forma robusta, sem precisar lidar manualmente com a complexidade
                dos arquivos XML e regras de validação da ABRASF.
            </p>
        ),
    },
    {
        question: "Preciso de certificado digital?",
        answer: (
            <p>
                Sim. Para assinar e transmitir os documentos para o ambiente
                nacional, você precisará de um certificado digital (A1 é o mais
                comum para automação) válido. O pacote incluirá ferramentas para
                auxiliar na assinatura digital (consulte o Roadmap).
            </p>
        ),
    },
    {
        question: "Funciona com qualquer prefeitura?",
        answer: (
            <p>
                O foco deste pacote é o <strong>Padrão Nacional</strong> de
                NFS-e. O objetivo do projeto nacional é unificar o layout.
                Portanto, ele funciona para emitir notas para qualquer município
                que já esteja aderente ou integrado ao ambiente de dados
                nacional da NFS-e.
            </p>
        ),
    },
];

function AccordionItem({
    item,
    isOpen,
    onClick,
}: {
    item: FAQItem;
    isOpen: boolean;
    onClick: () => void;
}) {
    return (
        <div className={styles.accordionItem}>
            <button
                className={styles.accordionHeader}
                onClick={onClick}
                aria-expanded={isOpen}
            >
                <span>{item.question}</span>
                <span className={clsx(styles.icon, isOpen && styles.open)}>
                    ▼
                </span>
            </button>
            {isOpen && (
                <div className={clsx(styles.accordionContent, styles.open)}>
                    {item.answer}
                </div>
            )}
        </div>
    );
}

export default function FAQ(): React.ReactElement {
    const [openIndex, setOpenIndex] = useState<number | null>(0);

    const handleToggle = (index: number) => {
        setOpenIndex(openIndex === index ? null : index);
    };

    return (
        <section className={styles.faqSection}>
            <div className={styles.container}>
                <h2 className={styles.title}>Perguntas Frequentes</h2>
                <div className={styles.accordionList}>
                    {FAQList.map((item, idx) => (
                        <AccordionItem
                            key={idx}
                            item={item}
                            isOpen={openIndex === idx}
                            onClick={() => handleToggle(idx)}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
}
