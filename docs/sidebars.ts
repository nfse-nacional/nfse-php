import type { SidebarsConfig } from "@docusaurus/plugin-content-docs";

const sidebars: SidebarsConfig = {
    docsSidebar: [
        "quickstart",
        {
            type: "link",
            label: "Exemplos Completos",
            href: "https://github.com/nfse-nacional/nfse-php/tree/main/examples",
        },
    ],
};

export default sidebars;
