<?php

namespace Nfse\Enums;

/**
 * Código da atividade do Simples Nacional (cAtvSN).
 *
 * Baseado na NT 009/2026 e na LC 123/2006.
 */
enum CodigoAtividadeSimplesNacional: string
{
    case ServicosAnexoIII = '7';
    case ServicosContabeisIssFixo = '8';
    case ServicosFatorR = '9';
    case TransporteMunicipal = '10';
    case LocacaoBensMoveisSemIss = '11';
    case ConstrucaoCivilAnexoIII = '12';
    case ConstrucaoCivilAnexoIV = '13';
    case ServicosAnexoIV = '14';
    case OperacoesNaoTributadas = '90';

    public function getDescription(): string
    {
        return match ($this) {
            self::ServicosAnexoIII => 'Prestação de serviços, cessão de direitos, de uso ou de espaço com incidência do ISS, tributados exclusivamente pelo Anexo III',
            self::ServicosContabeisIssFixo => 'Prestação de serviços contábeis autorizados a pagar o ISS em valor fixo em guia do Município - Anexo III',
            self::ServicosFatorR => 'Prestação de serviços sujeitos ao Fator R - Anexo III ou V',
            self::TransporteMunicipal => 'Prestação de serviços de transporte municipal rodoviário, metroviário, ferroviário e aquaviário de passageiros relacionados no subitem 16.01 da LC 116/2003 - Anexo III',
            self::LocacaoBensMoveisSemIss => 'Locação de bens móveis e operações com serviços, bens imateriais e direitos, inclusive com bens imóveis, sem incidência de ISS - Anexo III',
            self::ConstrucaoCivilAnexoIII => 'Prestação de serviços da área da construção civil relacionados nos subitens 7.02 e 7.05 da LC 116/2003 - Anexo III',
            self::ConstrucaoCivilAnexoIV => 'Prestação de serviços da área da construção civil relacionados nos subitens 7.02 e 7.05 da LC 116/2003 - Anexo IV',
            self::ServicosAnexoIV => 'Prestação de serviços - Anexo IV',
            self::OperacoesNaoTributadas => 'Operações não tributadas',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
