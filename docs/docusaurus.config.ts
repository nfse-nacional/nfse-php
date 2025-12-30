import { themes as prismThemes } from "prism-react-renderer";
import type { Config } from "@docusaurus/types";
import type * as Preset from "@docusaurus/preset-classic";

const config: Config = {
    title: "NFS-e Nacional PHP",
    tagline:
        "A maneira mais moderna e eficiente de integrar PHP com a NFS-e Nacional.",
    favicon: "img/favicon.ico",

    url: "https://nfse-nacional.github.io",
    baseUrl: "/",

    organizationName: "nfse-nacional",
    projectName: "nfse-php",

    onBrokenLinks: "warn",
    markdown: {
        format: "mdx",
        mermaid: true,
        hooks: {
            onBrokenMarkdownLinks: "warn",
        },
    },

    i18n: {
        defaultLocale: "pt-BR",
        locales: ["pt-BR"],
    },

    presets: [
        [
            "classic",
            {
                docs: {
                    sidebarPath: "./sidebars.ts",
                    editUrl:
                        "https://github.com/nfse-nacional/nfse-php/tree/main/docs/",
                },
                blog: false,
                theme: {
                    customCss: "./src/css/custom.css",
                },
            } satisfies Preset.Options,
        ],
    ],

    themeConfig: {
        image: "img/docusaurus-social-card.jpg",
        navbar: {
            title: "NFSe PHP",
            logo: {
                alt: "NFSe PHP Logo",
                src: "img/logo.svg",
            },
            items: [
                {
                    type: "docSidebar",
                    sidebarId: "docsSidebar",
                    position: "left",
                    label: "Documentação",
                },
                {
                    href: "https://github.com/nfse-nacional/nfse-php",
                    label: "GitHub",
                    position: "right",
                },
            ],
        },
        footer: {
            style: "dark",
            links: [
                {
                    title: "Documentação",
                    items: [
                        {
                            label: "Visão Geral",
                            to: "/docs/overview",
                        },
                        {
                            label: "DTOs",
                            to: "/docs/dtos",
                        },
                    ],
                },
                {
                    title: "Comunidade",
                    items: [
                        {
                            label: "GitHub Issues",
                            href: "https://github.com/nfse-nacional/nfse-php/issues",
                        },
                    ],
                },
            ],
            copyright: `Copyright © ${new Date().getFullYear()} NFSe PHP. Built with Docusaurus.`,
        },
        prism: {
            theme: prismThemes.github,
            darkTheme: prismThemes.dracula,
            additionalLanguages: ["php", "json", "bash", "typescript"],
        },
    } satisfies Preset.ThemeConfig,
};

export default config;
