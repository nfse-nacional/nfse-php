import React from "react";
import clsx from "clsx";
import styles from "./styles.module.css";

type AdvantageItem = {
    title: string;
    icon: string;
    description: React.ReactNode;
};

const AdvantageList: AdvantageItem[] = [
    {
        title: "Segurança de Tipagem",
        icon: "🛡️",
        description: (
            <>
                Esqueça os arrays associativos mágicos. Com DTOs, cada
                propriedade tem um tipo definido (<code>string</code>,{" "}
                <code>int</code>, <code>float</code>), garantindo que você nunca
                envie uma string onde deveria ser um número. O PHP 8+ cuida
                disso para você em tempo de execução.
            </>
        ),
    },
    {
        title: "Documentação Precisa e Viva",
        icon: "📚",
        description: (
            <>
                O código é a documentação. Ao instanciar um DTO, você sabe
                exatamente quais campos são obrigatórios, quais são opcionais e
                qual o formato esperado. Não é necessário consultar manuais
                externos de PDF o tempo todo.
            </>
        ),
    },
    {
        title: "Redução de Erros Humanos",
        icon: "🎯",
        description: (
            <>
                Erros de digitação em chaves de array (ex: <code>'cpl'</code> vs{" "}
                <code>'cnpj'</code>) são eliminados. O compilador e a IDE
                alertam imediatamente se você tentar acessar ou definir uma
                propriedade que não existe.
            </>
        ),
    },
    {
        title: "Semântica Interpretativa",
        icon: "🧠",
        description: (
            <>
                O código expressa a intenção de negócio. Em vez de estruturas
                genéricas, você trabalha com objetos que representam conceitos
                reais: <code>Tomador</code>, <code>Servico</code>,{" "}
                <code>Valores</code>. Isso torna o código mais legível e fácil
                de entender para novos desenvolvedores.
            </>
        ),
    },
    {
        title: "Autocompletar na IDE",
        icon: "⚡",
        description: (
            <>
                Aproveite o poder do Intellisense no VSCode ou PHPStorm. Ao
                digitar <code>$tomador-&gt;</code>, sua IDE lista todas as
                propriedades disponíveis, acelerando o desenvolvimento e
                evitando a necessidade de memorizar o layout da NFS-e.
            </>
        ),
    },
    {
        title: "Validação Centralizada",
        icon: "✅",
        description: (
            <>
                As regras de validação vivem dentro dos DTOs. Se um campo tem
                tamanho máximo ou formato específico, o DTO garante isso. O XML
                só é gerado se os dados estiverem válidos, evitando rejeições da
                API por erros de schema.
            </>
        ),
    },
];

function Advantage({ title, icon, description }: AdvantageItem) {
    return (
        <div className={styles.card}>
            <div className={styles.cardTitle}>
                <span className={styles.icon}>{icon}</span>
                {title}
            </div>
            <div className={styles.cardDescription}>{description}</div>
        </div>
    );
}

export default function DtoAdvantages(): React.ReactElement {
    return (
        <section className={styles.section}>
            <div className={styles.container}>
                <h2 className={styles.title}>Por que usamos DTOs?</h2>
                <div className={styles.grid}>
                    {AdvantageList.map((props, idx) => (
                        <Advantage key={idx} {...props} />
                    ))}
                </div>
            </div>
        </section>
    );
}
