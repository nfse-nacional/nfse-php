<?php

namespace Nfse\Pdf;

use DOMDocument;
use DOMElement;
use DOMXPath;
use InvalidArgumentException;
use Nfse\Dto\Nfse\NfseData;
use TCPDF;

/** Gera localmente o DANFSe v2.0 conforme a NT 008 v1.02. */
class DanfseGenerator
{
    private DOMXPath $xpath;

    public function generate(NfseData|string $nfse): string
    {
        $xml = $nfse instanceof NfseData ? $nfse->nfseXml : $nfse;
        if (! is_string($xml) || trim($xml) === '') {
            throw new InvalidArgumentException('O XML original da NFS-e é obrigatório para gerar o DANFSe.');
        }

        $dom = new DOMDocument;
        if (! @$dom->loadXML($xml, LIBXML_NONET | LIBXML_NOBLANKS)) {
            throw new InvalidArgumentException('XML da NFS-e inválido.');
        }
        $this->xpath = new DOMXPath($dom);

        $id = $this->value('/*[local-name()="NFSe"]/*[local-name()="infNFSe"]/@Id');
        $key = str_starts_with($id, 'NFS') ? substr($id, 3) : $id;
        if (! preg_match('/^\d{50}$/', $key)) {
            throw new InvalidArgumentException('A chave de acesso da NFS-e deve conter 50 dígitos.');
        }

        $pdf = new class('P', 'mm', 'A4', true, 'UTF-8', false) extends TCPDF {
            public function Header(): void {}
            public function Footer(): void {}
        };
        $pdf->SetCreator('nfse-php');
        $pdf->SetTitle('DANFSe '.$key);
        $pdf->SetMargins(1.5, 1.5, 1.5);
        $pdf->SetAutoPageBreak(false, 1.5);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetLineWidth(0.176); // 0,5 pt
        $pdf->Rect(1.5, 1.5, 207, 294, 'D', [], []); // borda de página

        $cancelled = $this->has("//*[local-name()='infEvento']//*[local-name()='e101101' or local-name()='e105102']");
        $substituted = $this->has("//*[local-name()='infEvento']//*[local-name()='e105102']");
        if ($cancelled || $substituted) {
            $pdf->SetTextColor(166, 166, 166);
            $pdf->SetFont('helvetica', '', 50);
            $pdf->StartTransform();
            $pdf->Rotate(35, 105, 148);
            $pdf->Text(47, 145, $substituted ? 'SUBSTITUÍDA' : 'CANCELADA');
            $pdf->StopTransform();
            $pdf->SetTextColor(0, 0, 0);
        }

        $pdf->SetFont('helvetica', '', 7);
        $pdf->writeHTML($this->html($key), true, false, true, false, '');
        $this->drawHeader($pdf);
        $pdf->write2DBarcode(
            'https://www.nfse.gov.br/ConsultaPublica/?tpc=1&chave='.$key,
            'QRCODE,M', 174.8, 16.7, 18, 18,
            ['border' => 0, 'padding' => 0, 'fgcolor' => [0, 0, 0], 'bgcolor' => [255, 255, 255]],
            'N'
        );
        if ($pdf->getNumPages() !== 1 || $pdf->GetY() > 294) {
            throw new \RuntimeException('O conteúdo do DANFSe excedeu uma página A4. Reduza os textos livres do XML.');
        }

        return $pdf->Output('', 'S');
    }

    private function html(string $key): string
    {
        $inf = "/*[local-name()='NFSe']/*[local-name()='infNFSe']";
        $dps = "$inf/*[local-name()='DPS']/*[local-name()='infDPS']";
        $emit = "$inf/*[local-name()='emit']";
        $prest = "$dps/*[local-name()='prest']";
        $toma = "$dps/*[local-name()='toma']";
        $interm = "$dps/*[local-name()='interm']";
        $dest = "$dps/*[local-name()='IBSCBS']/*[local-name()='dest']";
        $header = '<table class="box gray"><tr><td><br><br><br><br></td></tr></table>';

        $ident = '<table class="box"><tr><td width="75%"><b>CHAVE DE ACESSO DA NFS-e</b><br>'.$this->e($key).'<br><table><tr>'.$this->cell('NÚMERO DA NFS-e', $this->value("$inf/*[local-name()='nNFSe']"), 33).$this->cell('COMPETÊNCIA DA NFS-e', $this->date($this->value("$dps/*[local-name()='dCompet']")), 33).$this->cell('DATA E HORA DA EMISSÃO DA NFS-e', $this->dateTime($this->value("$inf/*[local-name()='dhProc']")), 34).'</tr><tr>'.$this->cell('NÚMERO DA DPS', $this->value("$dps/*[local-name()='nDPS']"), 33).$this->cell('SÉRIE DA DPS', $this->value("$dps/*[local-name()='serie']"), 33).$this->cell('DATA E HORA DA EMISSÃO DA DPS', $this->dateTime($this->value("$dps/*[local-name()='dhEmi']")), 34).'</tr><tr><td class="gray" width="33%"><b class="label">EMITENTE DA NFS-e</b><br>'.$this->show($this->label($this->value("$dps/*[local-name()='tpEmit']"), ['1'=>'Prestador','2'=>'Tomador','3'=>'Intermediário'])).'</td>'.$this->cell('SITUAÇÃO DA NFS-e', $this->status(), 33).$this->cell('FINALIDADE', $this->label($this->value("$dps/*[local-name()='IBSCBS']/*[local-name()='finNFSe']"), ['0'=>'NFS-e regular','1'=>'Crédito','2'=>'Débito']), 34).'</tr></table></td><td width="25%" align="center"><br><br><br><br><br><br><br><span class="tiny">A autenticidade desta NFS-e pode ser verificada pela leitura deste código QR ou pela consulta da chave no portal nacional.</span></td></tr></table>';

        $html = $this->styles().$header.$ident;
        $html .= $this->party('PRESTADOR / FORNECEDOR', $prest, $emit, true);
        $html .= $this->party('TOMADOR / ADQUIRENTE', $toma, $toma, false, 'TOMADOR/ADQUIRENTE DA OPERAÇÃO NÃO IDENTIFICADO NA NFS-e');
        $indDest = $this->value("$dps/*[local-name()='IBSCBS']/*[local-name()='indDest']");
        $html .= $indDest === '0' ? $this->messageBlock('DESTINATÁRIO DA OPERAÇÃO', 'O DESTINATÁRIO É O PRÓPRIO TOMADOR/ADQUIRENTE DA OPERAÇÃO') : $this->party('DESTINATÁRIO DA OPERAÇÃO', $dest, $dest, false, 'DESTINATÁRIO DA OPERAÇÃO NÃO IDENTIFICADO NA NFS-e');
        $html .= $this->party('INTERMEDIÁRIO DA OPERAÇÃO', $interm, $interm, false, 'INTERMEDIÁRIO DA OPERAÇÃO NÃO IDENTIFICADO NA NFS-e');
        $html .= $this->serviceBlock($inf, $dps);
        $html .= $this->taxBlocks($inf, $dps);
        $html .= $this->totals($inf, $dps);
        $html .= $this->complementary($inf, $dps);

        return $html;
    }

    private function styles(): string
    {
        return '<style>table{font-family:helvetica;font-size:7pt;border-collapse:collapse}.box{border:0.5pt solid #000}.box td{padding:2px}.gray,.title,.emitter{background-color:#f2f2f2}.title{font-family:helvetica;font-size:7pt;font-weight:bold}.label{font-size:6pt;font-weight:bold}.doc{font-size:9pt}.invalid{font-size:9pt;font-weight:bold;color:#f00}.tiny{font-size:6pt}.field{font-size:7pt}.section{margin-top:0}</style>';
    }

    private function drawHeader(TCPDF $pdf): void
    {
        $inf = "/*[local-name()='NFSe']/*[local-name()='infNFSe']";
        $dps = "$inf/*[local-name()='DPS']/*[local-name()='infDPS']";
        $emit = "$inf/*[local-name()='emit']";
        $logo = __DIR__.'/nfse-logo.jpg';
        if (is_file($logo)) $pdf->Image($logo, 2.5, 2.5, 38, 9, 'JPG');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(43, 2.5);
        $pdf->Cell(108, 4, 'DANFSe v2.0', 0, 0, 'C');
        $pdf->SetXY(43, 6);
        $pdf->Cell(108, 4, 'Documento Auxiliar da NFS-e', 0, 0, 'C');
        if ($this->value("$dps/*[local-name()='tpAmb']") === '2') {
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetXY(43, 9.5);
            $pdf->Cell(108, 4, 'NFS-e SEM VALIDADE JURÍDICA', 0, 0, 'C');
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 6);
        $right = 'Município: '.$this->value("$inf/*[local-name()='xLocEmi']").' / '.$this->value("$emit/*[local-name()='enderNac']/*[local-name()='UF']")."\n".
            'Ambiente gerador: '.$this->label($this->value("$inf/*[local-name()='ambGer']"), ['1'=>'Município','2'=>'SEFIN Nacional'])."\n".
            'Ambiente: '.($this->value("$dps/*[local-name()='tpAmb']") === '2' ? 'Homologação' : 'Produção');
        $pdf->SetXY(154, 2.5);
        $pdf->MultiCell(52, 3, $right, 0, 'C', false, 1);
    }

    private function party(string $title, string $base, string $fallback, bool $provider, ?string $missingMessage = null): string
    {
        if (! $this->has($base)) {
            return $this->messageBlock($title, $missingMessage ?? $title.' NÃO IDENTIFICADO NA NFS-e');
        }
        $doc = $this->first($base, ['CNPJ','CPF','NIF']);
        $name = $this->value("$base/*[local-name()='xNome']") ?: $this->value("$fallback/*[local-name()='xNome']");
        $im = $this->value("$base/*[local-name()='IM']");
        $phone = $this->value("$base/*[local-name()='fone']");
        $email = $this->value("$base/*[local-name()='email']");
        $end = $this->address($base, $fallback);
        if ($provider && trim($end['city'], ' /') === '') {
            $end['city'] = $this->value("/*[local-name()='NFSe']/*[local-name()='infNFSe']/*[local-name()='xLocEmi']").($this->value("$fallback/*[local-name()='enderNac']/*[local-name()='UF']") ? ' / '.$this->value("$fallback/*[local-name()='enderNac']/*[local-name()='UF']") : '');
        }
        $html = $this->blockTitle($title).'<table class="box"><tr>'.$this->cell('CNPJ / CPF / NIF', $this->formatDocument($doc), 25).$this->cell('INDICADOR MUNICIPAL (INSCRIÇÃO)', $im, 25).$this->cell('TELEFONE', $this->formatPhone($phone), 25).$this->cell('NOME / NOME EMPRESARIAL', $name, 25).'</tr><tr>'.$this->cell('MUNICÍPIO / SIGLA UF', $end['city'], 50).$this->cell('CÓDIGO IBGE / CEP', $end['code'], 50).'</tr><tr>'.$this->cell('ENDEREÇO', $end['address'], 50).$this->cell('E-MAIL', $email, 50).'</tr>';
        if ($provider) {
            $html .= '<tr>'.$this->cell('SIMPLES NACIONAL NA DATA DE COMPETÊNCIA', $this->label($this->value("$base/*[local-name()='regTrib']/*[local-name()='opSimpNac']"), ['1'=>'Não optante','2'=>'Optante - MEI','3'=>'Optante - ME/EPP']), 50).$this->cell('REGIME DE APURAÇÃO TRIBUTÁRIA PELO SN', $this->label($this->value("$base/*[local-name()='regTrib']/*[local-name()='regApTribSN']"), ['1'=>'Regime de apuração dos tributos federais e municipal pelo SN','2'=>'Tributos federais pelo SN e ISSQN por fora']), 50).'</tr>';
        }
        return $html.'</table>';
    }

    private function serviceBlock(string $inf, string $dps): string
    {
        $serv = "$dps/*[local-name()='serv']";
        $code = "$serv/*[local-name()='cServ']";
        $national = $this->value("$code/*[local-name()='cTribNac']");
        $municipal = $this->value("$code/*[local-name()='cTribMun']");
        return $this->blockTitle('SERVIÇO PRESTADO').'<table class="box"><tr>'.$this->cell('CÓDIGO DE TRIBUTAÇÃO NACIONAL / MUNICIPAL', trim($national.' / '.$municipal, ' /'), 33).$this->cell('CÓDIGO DA NBS', $this->value("$code/*[local-name()='cNBS']"), 17).$this->cell('LOCAL DA PRESTAÇÃO / SIGLA UF / PAÍS', $this->value("$inf/*[local-name()='xLocPrestacao']"), 50).'</tr><tr><td><b class="label">DESCRIÇÃO DO CÓDIGO DE TRIBUTAÇÃO NACIONAL / MUNICIPAL</b><br>'.$this->show($this->value("$inf/*[local-name()='xTribMun']") ?: $this->value("$inf/*[local-name()='xTribNac']")).'</td></tr><tr><td><b class="label">DESCRIÇÃO DO SERVIÇO</b><br>'.$this->show($this->value("$code/*[local-name()='xDescServ']"), 1300).'</td></tr></table>';
    }

    private function taxBlocks(string $inf, string $dps): string
    {
        $mun = "$dps/*[local-name()='valores']/*[local-name()='trib']/*[local-name()='tribMun']";
        $vals = "$inf/*[local-name()='valores']";
        $html = $this->blockTitle('TRIBUTAÇÃO MUNICIPAL (ISSQN)');
        if (! $this->has($mun) || $this->value("$mun/*[local-name()='tribISSQN']") === '4') {
            $html .= '<table class="box"><tr><td>TRIBUTAÇÃO MUNICIPAL (ISSQN) - OPERAÇÃO NÃO SUJEITA AO ISSQN</td></tr></table>';
        } else {
            $html .= '<table class="box"><tr>'.$this->cell('TIPO DE TRIBUTAÇÃO DO ISSQN', $this->label($this->value("$mun/*[local-name()='tribISSQN']"), ['1'=>'Operação tributável','2'=>'Imunidade','3'=>'Exportação','4'=>'Não incidência']), 25).$this->cell('MUNICÍPIO / SIGLA UF / PAÍS DA INCIDÊNCIA', $this->value("$inf/*[local-name()='xLocIncid']"), 25).$this->cell('BC ISSQN', $this->money($this->value("$vals/*[local-name()='vBC']")), 17).$this->cell('ALÍQUOTA APLICADA', $this->percent($this->value("$vals/*[local-name()='pAliqAplic']")), 16).$this->cell('ISSQN APURADO', $this->money($this->value("$vals/*[local-name()='vISSQN']")), 17).'</tr></table>';
        }
        $fed = "$dps/*[local-name()='valores']/*[local-name()='trib']/*[local-name()='tribFed']";
        $html .= $this->blockTitle('TRIBUTAÇÃO FEDERAL (EXCETO CBS)').'<table class="box"><tr>'.$this->cell('IRRF', $this->money($this->value("$fed/*[local-name()='vRetIRRF']")), 20).$this->cell('CONTRIBUIÇÃO PREVIDENCIÁRIA - RETIDA', $this->money($this->value("$fed/*[local-name()='vRetCP']")), 27).$this->cell('CONTRIBUIÇÕES SOCIAIS - RETIDAS', $this->money($this->value("$fed/*[local-name()='vRetCSLL']")), 27).$this->cell('PIS / COFINS', $this->money($this->value("$fed/*[local-name()='piscofins']/*[local-name()='vPis']")).' / '.$this->money($this->value("$fed/*[local-name()='piscofins']/*[local-name()='vCofins']")), 26).'</tr></table>';
        $ibsdps = "$dps/*[local-name()='IBSCBS']";
        $ibsnf = "$inf/*[local-name()='IBSCBS']";
        $html .= $this->blockTitle('TRIBUTAÇÃO IBS / CBS').'<table class="box"><tr>'.$this->cell('CST / cClassTrib', trim($this->value("$ibsdps//*[local-name()='CST']").' / '.$this->value("$ibsdps//*[local-name()='cClassTrib']"), ' /'), 25).$this->cell('INDICADOR / CÓDIGO IBGE / MUNICÍPIO INCIDÊNCIA', trim($this->value("$ibsdps/*[local-name()='cIndOp']").' / '.$this->value("$ibsnf/*[local-name()='cLocalidadeIncid']").' / '.$this->value("$ibsnf/*[local-name()='xLocalidadeIncid']"), ' /'), 45).$this->cell('BASE DE CÁLCULO', $this->money($this->value("$ibsnf/*[local-name()='valores']/*[local-name()='vBC']")), 15).$this->cell('TOTAL IBS / CBS', $this->money($this->value("$ibsnf//*[local-name()='vIBSTot']")).' / '.$this->money($this->value("$ibsnf//*[local-name()='vCBS']")), 15).'</tr></table>';
        return $html;
    }

    private function totals(string $inf, string $dps): string
    {
        $v = "$inf/*[local-name()='valores']";
        $dv = "$dps/*[local-name()='valores']";
        $ibs = "$inf/*[local-name()='IBSCBS']";
        $tax = (float) ($this->value("$ibs//*[local-name()='vIBSTot']") ?: 0) + (float) ($this->value("$ibs//*[local-name()='vCBS']") ?: 0);
        return $this->blockTitle('VALOR TOTAL DA NFS-e').'<table class="box"><tr>'.$this->cell('VALOR DA OPERAÇÃO / SERVIÇO', $this->money($this->value("$dv/*[local-name()='vServPrest']/*[local-name()='vServ']")), 16).$this->cell('DESCONTO INCONDICIONADO', $this->money($this->value("$dv/*[local-name()='vDescCondIncond']/*[local-name()='vDescIncond']")), 14).$this->cell('DESCONTO CONDICIONADO', $this->money($this->value("$dv/*[local-name()='vDescCondIncond']/*[local-name()='vDescCond']")), 14).$this->cell('TOTAL DAS RETENÇÕES', $this->money($this->value("$v/*[local-name()='vTotalRet']")), 14).$this->cell('VALOR LÍQUIDO DA NFS-e', $this->money($this->value("$v/*[local-name()='vLiq']")), 14).$this->cell('TOTAL DO IBS/CBS', $this->money((string) $tax), 14).'<td class="gray" width="14%"><b class="label">VALOR LÍQUIDO DA NFS-e + IBS/CBS</b><br>'.$this->money($this->value("$ibs//*[local-name()='vTotNF']") ?: (string) ((float) $this->value("$v/*[local-name()='vLiq']") + $tax)).'</td></tr></table>';
    }

    private function complementary(string $inf, string $dps): string
    {
        $parts = [];
        $map = [
            'Inf. Cont.' => "$dps/*[local-name()='serv']/*[local-name()='infoCompl']/*[local-name()='xInfComp']",
            'NFS-e Subst.' => "$dps/*[local-name()='subst']/*[local-name()='chSubstda']",
            'Inf. A. T. Mun.' => "$inf/*[local-name()='xOutInf']",
        ];
        foreach ($map as $label => $path) {
            $value = $this->value($path);
            if ($value !== '') $parts[] = $label.': '.$value;
        }
        $tot = "$dps/*[local-name()='valores']/*[local-name()='trib']/*[local-name()='totTrib']";
        $parts[] = 'Totais Aproximados dos Tributos cfe. Lei nº 12.741/2012: Federais: '.$this->taxApprox($tot, 'Fed').' ; Estaduais: '.$this->taxApprox($tot, 'Est').' ; Municipais: '.$this->taxApprox($tot, 'Mun');
        return $this->blockTitle('INFORMAÇÕES COMPLEMENTARES').'<table class="box"><tr><td>'.$this->show(implode(' | ', $parts), 2000).'</td></tr></table>';
    }

    private function address(string $base, string $fallback): array
    {
        $end = $this->has("$base/*[local-name()='end']") ? "$base/*[local-name()='end']" : $base;
        if (! $this->has("$end/*[local-name()='enderNac']") && $this->has("$fallback/*[local-name()='enderNac']")) $end = $fallback;
        $nat = "$end/*[local-name()='enderNac']";
        $street = array_filter([$this->value("$nat/*[local-name()='xLgr']"), $this->value("$nat/*[local-name()='nro']"), $this->value("$nat/*[local-name()='xCpl']"), $this->value("$nat/*[local-name()='xBairro']")]);
        return ['city'=>$this->value("$nat/*[local-name()='xMun']").($this->value("$nat/*[local-name()='UF']") ? ' / '.$this->value("$nat/*[local-name()='UF']") : ''), 'code'=>trim($this->value("$nat/*[local-name()='cMun']").' / '.$this->formatCep($this->value("$nat/*[local-name()='CEP']")), ' /'), 'address'=>implode(', ', $street)];
    }

    private function blockTitle(string $title): string { return '<table class="box title"><tr><td>'.$this->e($title).'</td></tr></table>'; }
    private function messageBlock(string $title, string $message): string { return $this->blockTitle($title).'<table class="box"><tr><td>'.$this->e($message).'</td></tr></table>'; }
    private function cell(string $label, string $value, int $width): string { return '<td width="'.$width.'%"><b class="label">'.$this->e($label).'</b><br>'.$this->show($value).'</td>'; }
    private function value(string $query): string { $nodes = $this->xpath->query($query); return $nodes && $nodes->length ? trim($nodes->item(0)->nodeValue) : ''; }
    private function has(string $query): bool { $nodes = $this->xpath->query($query); return (bool) ($nodes && $nodes->length); }
    private function first(string $base, array $names): string { foreach ($names as $name) { $v = $this->value("$base/*[local-name()='$name']"); if ($v !== '') return $v; } return ''; }
    private function show(string $value, int $max = 170): string { $value = $value === '' ? '-' : $value; if (mb_strlen($value) > $max) $value = mb_substr($value, 0, $max - 3).'...'; return $this->e($value); }
    private function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    private function label(string $value, array $labels): string { return $labels[$value] ?? ($value !== '' ? $value : '-'); }
    private function status(): string { return $this->label($this->value("/*[local-name()='NFSe']/*[local-name()='infNFSe']/*[local-name()='cStat']"), ['100'=>'NFS-e Gerada','101'=>'NFS-e de Substituição Gerada','102'=>'NFS-e de Decisão Judicial','103'=>'NFS-e Avulsa','107'=>'NFS-e MEI']); }
    private function date(string $v): string { if ($v === '') return '-'; try { return (new \DateTimeImmutable($v))->format('d/m/Y'); } catch (\Throwable) { return $v; } }
    private function dateTime(string $v): string { if ($v === '') return '-'; try { return (new \DateTimeImmutable($v))->format('d/m/Y H:i:s'); } catch (\Throwable) { return $v; } }
    private function money(string $v): string { return $v === '' ? '-' : 'R$ '.number_format((float) $v, 2, ',', '.'); }
    private function percent(string $v): string { return $v === '' ? '-' : number_format((float) $v, 2, ',', '.').' %'; }
    private function formatDocument(string $v): string { $d=preg_replace('/\D/','',$v); if(strlen($d)===14)return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/','$1.$2.$3/$4-$5',$d); if(strlen($d)===11)return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/','$1.$2.$3-$4',$d); return $v; }
    private function formatCep(string $v): string { $d=preg_replace('/\D/','',$v); return strlen($d)===8 ? substr($d,0,5).'-'.substr($d,5) : $v; }
    private function formatPhone(string $v): string { return $v; }
    private function taxApprox(string $base, string $suffix): string { $money=$this->value("$base/*[local-name()='vTotTrib$suffix']"); if($money!=='')return $this->money($money); $pct=$this->value("$base/*[local-name()='pTotTrib$suffix']"); return $this->percent($pct); }
}
