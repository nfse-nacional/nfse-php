import type { SidebarsConfig } from "@docusaurus/plugin-content-docs";

const sidebars: SidebarsConfig = {
    docsSidebar: [
        "overview",
        "quickstart",
        "como-se-integrar",
        {
            type: "category",
            label: "Guias Práticos",
            items: [
                "guides/emitir",
                "guides/consultar",
                "guides/eventos",
                "guides/substituicao",
            ],
        },
        {
            type: "category",
            label: "Exemplos Práticos",
            items: [
                "full-example",
                "examples/tomador-pf",
                "examples/tomador-pj",
                "examples/tomador-exterior",
                "examples/construcao-civil",
                "examples/retencoes",
                "examples/pis-cofins",
                "examples/exportacao",
                "advanced-scenarios",
            ],
        },
        {
            type: "category",
            label: "Tipos (DTOs)",
            items: [
                "types/main-documents",
                "types/base-info",
                "types/actors",
                "types/service-location",
                "types/values-taxation",
                "types/deductions",
                "types/others",
            ],
        },
        "dtos",
        "validations",
        "xml-serialization",
        "digital-signature",
        "signing-dps",
        "xml-signer",
        {
            type: "category",
            label: "Serviços (Web Services)",
            items: [
                "services/overview",
                "services/contribuinte",
                "services/municipio",
                "web-services",
            ],
        },
        {
            type: "category",
            label: "Utilitários",
            items: [
                "utilities/cpf-cnpj-formatter",
                "utilities/tax-calculator",
                "utilities/id-generator",
                "utilities/cpf-cnpj-generator",
            ],
        },
        "typescript",
        "tests",
        "schema-rules",
    ],
};

export default sidebars;
