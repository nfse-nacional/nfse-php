<?php

namespace Nfse\Enums;

/**
 * Tipo de detalhamento da cobrança condominial.
 *
 * Baseado no schema: TSRTCTpDetCobranca
 */
enum TipoDetalhamentoCobrancaCondominio: string
{
    case CondominioComumCrd = '001';
    case CondominioComumMetroQuadrado = '002';
    case CondominioComumFixo = '003';
    case CondominioComumFracao = '004';
    case CondominioComumPercentual = '005';
    case CondominioCmm = '006';
    case EnergiaEletrica = '007';
    case Agua = '008';
    case ArCondicionado = '009';
    case Telefone = '010';
    case Internet = '011';
    case ControlePragas = '012';
    case Exaustao = '013';
    case Gas = '014';
    case Iptu = '015';
    case TaxaArea = '016';
    case Manutencao = '017';
    case Multa = '018';
    case Seguro = '019';
    case TaxaBombeiro = '020';
    case TaxaAdministracao = '021';
    case TaxaForo = '022';
    case Limpeza = '023';
    case TaxaLixo = '024';
    case Tapume = '025';
    case InstalacaoAlarme = '026';
    case Seguranca = '027';
    case FundoPromocaoPropaganda = '028';
    case AnaliseProjeto = '029';
    case FundoReserva = '030';
    case LaudosVistorias = '031';
    case DeteccaoFumaca = '032';
    case ReanaliseProjeto = '033';
    case TaxaExtra = '034';
    case AreaVaga = '035';
    case CondominioIrrecuperavel = '036';
    case Outro = '999';

    public function getDescription(): string
    {
        return match ($this) {
            self::CondominioComumCrd => 'Cond. Comum CRD',
            self::CondominioComumMetroQuadrado => 'Cond. Comum M2',
            self::CondominioComumFixo => 'Cond. Comum Fixo',
            self::CondominioComumFracao => 'Cond. Comum Fração',
            self::CondominioComumPercentual => 'Cond. Comum Percentual',
            self::CondominioCmm => 'Condomínio CMM',
            self::EnergiaEletrica => 'Energia Elétrica',
            self::Agua => 'Água',
            self::ArCondicionado => 'Ar Condicionado',
            self::Telefone => 'Telefone',
            self::Internet => 'Internet',
            self::ControlePragas => 'Controle de Pragas',
            self::Exaustao => 'Exaustão',
            self::Gas => 'Gás',
            self::Iptu => 'IPTU',
            self::TaxaArea => 'Taxa Área',
            self::Manutencao => 'Manutenção',
            self::Multa => 'Multa',
            self::Seguro => 'Seguro',
            self::TaxaBombeiro => 'Taxa Bombeiro',
            self::TaxaAdministracao => 'Taxa Administração',
            self::TaxaForo => 'Taxa Foro',
            self::Limpeza => 'Limpeza',
            self::TaxaLixo => 'Taxa de Lixo',
            self::Tapume => 'Tapume',
            self::InstalacaoAlarme => 'Instalação Alarme',
            self::Seguranca => 'Segurança',
            self::FundoPromocaoPropaganda => 'Fundo de Promoção e Propaganda',
            self::AnaliseProjeto => 'Análise de Projeto',
            self::FundoReserva => 'Fundo de Reserva',
            self::LaudosVistorias => 'Laudos e Vistorias',
            self::DeteccaoFumaca => 'Detecção de Fumaça',
            self::ReanaliseProjeto => 'Reanálise de Projeto',
            self::TaxaExtra => 'Taxa Extra',
            self::AreaVaga => 'Área Vaga',
            self::CondominioIrrecuperavel => 'Condomínio Irrecuperável',
            self::Outro => 'Outro',
        };
    }

    public function label(): string
    {
        return $this->getDescription();
    }
}
