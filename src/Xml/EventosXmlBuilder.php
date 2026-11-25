<?php

namespace Nfse\Xml;

use DOMDocument;
use DOMElement;
use Nfse\Dto\Nfse\AnaliseFiscalData;
use Nfse\Dto\Nfse\AnaliseFiscalSolicitacaoData;
use Nfse\Dto\Nfse\AnulacaoRejeicaoData;
use Nfse\Dto\Nfse\BloqueioPorOficioData;
use Nfse\Dto\Nfse\CancelamentoData;
use Nfse\Dto\Nfse\CancelamentoPorOficioData;
use Nfse\Dto\Nfse\CancelamentoSubstituicaoData;
use Nfse\Dto\Nfse\ConfirmacaoIntermediarioData;
use Nfse\Dto\Nfse\ConfirmacaoPrestadorData;
use Nfse\Dto\Nfse\ConfirmacaoTacitaData;
use Nfse\Dto\Nfse\ConfirmacaoTomadorData;
use Nfse\Dto\Nfse\DesbloqueioPorOficioData;
use Nfse\Dto\Nfse\InfPedRegData;
use Nfse\Dto\Nfse\PedRegEventoData;
use Nfse\Dto\Nfse\RejeicaoIntermediarioData;
use Nfse\Dto\Nfse\RejeicaoPrestadorData;
use Nfse\Dto\Nfse\RejeicaoTomadorData;
use Nfse\Support\SchemaText;

class EventosXmlBuilder
{
    private DOMDocument $dom;

    public function buildPedRegEvento(PedRegEventoData $data): string
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = false;

        $root = $this->dom->createElementNS('http://www.sped.fazenda.gov.br/nfse', 'pedRegEvento');
        $root->setAttribute('versao', (string) $data->versao);
        $this->dom->appendChild($root);

        $inf = $this->dom->createElement('infPedReg');

        // Id: PRE + chNFSe + tipoEvento (PRE + 56 dígitos)
        $ch = $data->infPedReg->chaveNfse;
        $tipo = $data->infPedReg->tipoEvento;
        $inf->setAttribute('Id', "PRE{$ch}{$tipo}");

        $this->appendElement($inf, 'tpAmb', (string) $data->infPedReg->tipoAmbiente);
        $this->appendElement($inf, 'verAplic', $data->infPedReg->versaoAplicativo);
        $this->appendElement($inf, 'dhEvento', $data->infPedReg->dataHoraEvento);

        if ($data->infPedReg->cnpjAutor) {
            $this->appendElement($inf, 'CNPJAutor', $data->infPedReg->cnpjAutor);
        }
        if ($data->infPedReg->cpfAutor) {
            $this->appendElement($inf, 'CPFAutor', $data->infPedReg->cpfAutor);
        }

        $this->appendElement($inf, 'chNFSe', $data->infPedReg->chaveNfse);
        $this->appendEvento($inf, $data->infPedReg);

        $root->appendChild($inf);

        $xml = $this->dom->saveXML($this->dom->documentElement, LIBXML_NOXMLDECL);

        return str_replace(["\n", "\r", "\t"], '', $xml);
    }

    private function appendEvento(DOMElement $inf, InfPedRegData $data): void
    {
        if ($data->e101101) {
            $this->appendCancelamento($inf, 'e101101', $data->e101101);
        }
        if ($data->e105102) {
            $this->appendCancelamentoSubstituicao($inf, $data->e105102);
        }
        if ($data->e101103) {
            $this->appendSolicitacaoAnalise($inf, $data->e101103);
        }
        if ($data->e105104) {
            $this->appendAnaliseFiscal($inf, 'e105104', $data->e105104);
        }
        if ($data->e105105) {
            $this->appendAnaliseFiscal($inf, 'e105105', $data->e105105);
        }
        if ($data->e202201) {
            $this->appendDescricao($inf, 'e202201', $data->e202201);
        }
        if ($data->e203202) {
            $this->appendDescricaoTomador($inf, $data->e203202);
        }
        if ($data->e204203) {
            $this->appendDescricaoIntermediario($inf, $data->e204203);
        }
        if ($data->e205204) {
            $this->appendDescricaoTacita($inf, $data->e205204);
        }
        if ($data->e202205) {
            $this->appendRejeicaoPrestador($inf, $data->e202205);
        }
        if ($data->e203206) {
            $this->appendRejeicaoTomador($inf, $data->e203206);
        }
        if ($data->e204207) {
            $this->appendRejeicaoIntermediario($inf, $data->e204207);
        }
        if ($data->e205208) {
            $this->appendAnulacao($inf, $data->e205208);
        }
        if ($data->e305101) {
            $this->appendCancelamentoOficio($inf, $data->e305101);
        }
        if ($data->e305102) {
            $this->appendBloqueio($inf, $data->e305102);
        }
        if ($data->e305103) {
            $this->appendDesbloqueio($inf, $data->e305103);
        }
    }

    private function appendCancelamento(DOMElement $parent, string $tag, CancelamentoData $data): void
    {
        $evento = $this->dom->createElement($tag);
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'cMotivo', $data->codigoMotivo);
        $this->appendElement($evento, 'xMotivo', $data->motivo);
        $parent->appendChild($evento);
    }

    private function appendCancelamentoSubstituicao(DOMElement $parent, CancelamentoSubstituicaoData $data): void
    {
        $evento = $this->dom->createElement('e105102');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'cMotivo', $data->codigoMotivo);
        $this->appendElement($evento, 'xMotivo', $data->descricaoMotivo);
        $this->appendElement($evento, 'chSubstituta', $data->chaveNfseSubstituta);
        $parent->appendChild($evento);
    }

    private function appendSolicitacaoAnalise(DOMElement $parent, AnaliseFiscalSolicitacaoData $data): void
    {
        $evento = $this->dom->createElement('e101103');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'cMotivo', $data->codigoMotivo);
        $this->appendElement($evento, 'xMotivo', $data->motivo);
        $parent->appendChild($evento);
    }

    private function appendAnaliseFiscal(DOMElement $parent, string $tag, AnaliseFiscalData $data): void
    {
        $evento = $this->dom->createElement($tag);
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'CPFAgTrib', $data->cpfAgenteTributario);
        $this->appendElement($evento, 'nProcAdm', $data->numeroProcessoAdministrativo);
        $this->appendElement($evento, 'cMotivo', $data->codigoMotivo);
        $this->appendElement($evento, 'xMotivo', $data->descricaoMotivo);
        $parent->appendChild($evento);
    }

    private function appendDescricao(DOMElement $parent, string $tag, ConfirmacaoPrestadorData $data): void
    {
        $evento = $this->dom->createElement($tag);
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $parent->appendChild($evento);
    }

    private function appendDescricaoTomador(DOMElement $parent, ConfirmacaoTomadorData $data): void
    {
        $evento = $this->dom->createElement('e203202');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $parent->appendChild($evento);
    }

    private function appendDescricaoIntermediario(DOMElement $parent, ConfirmacaoIntermediarioData $data): void
    {
        $evento = $this->dom->createElement('e204203');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $parent->appendChild($evento);
    }

    private function appendDescricaoTacita(DOMElement $parent, ConfirmacaoTacitaData $data): void
    {
        $evento = $this->dom->createElement('e205204');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $parent->appendChild($evento);
    }

    private function appendRejeicaoPrestador(DOMElement $parent, RejeicaoPrestadorData $data): void
    {
        $this->appendRejeicao($parent, 'e202205', $data->descricao, $data->codigoMotivo, $data->motivo);
    }

    private function appendRejeicaoTomador(DOMElement $parent, RejeicaoTomadorData $data): void
    {
        $this->appendRejeicao($parent, 'e203206', $data->descricao, $data->codigoMotivo, $data->motivo);
    }

    private function appendRejeicaoIntermediario(DOMElement $parent, RejeicaoIntermediarioData $data): void
    {
        $this->appendRejeicao($parent, 'e204207', $data->descricao, $data->codigoMotivo, $data->motivo);
    }

    private function appendRejeicao(DOMElement $parent, string $tag, ?string $descricao, ?string $codigoMotivo, ?string $motivo): void
    {
        $evento = $this->dom->createElement($tag);
        $this->appendElement($evento, 'xDesc', $descricao);
        $this->appendElement($evento, 'cMotivo', $codigoMotivo);
        $this->appendElement($evento, 'xMotivo', $motivo);
        $parent->appendChild($evento);
    }

    private function appendAnulacao(DOMElement $parent, AnulacaoRejeicaoData $data): void
    {
        $evento = $this->dom->createElement('e205208');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'CPFAgTrib', $data->cpfAgenteTributario);
        $this->appendElement($evento, 'idEvManifRej', $data->idEventoManifestacaoRejeicao);
        $this->appendElement($evento, 'xMotivo', $data->motivo);
        $parent->appendChild($evento);
    }

    private function appendCancelamentoOficio(DOMElement $parent, CancelamentoPorOficioData $data): void
    {
        $evento = $this->dom->createElement('e305101');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'CPFAgTrib', $data->cpfAgenteTributario);
        $this->appendElement($evento, 'nProcAdm', $data->numeroProcessoAdministrativo);
        $this->appendElement($evento, 'xProcAdm', $data->descricaoProcessoAdministrativo);
        $parent->appendChild($evento);
    }

    private function appendBloqueio(DOMElement $parent, BloqueioPorOficioData $data): void
    {
        $evento = $this->dom->createElement('e305102');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'CPFAgTrib', $data->cpfAgenteTributario);
        $this->appendElement($evento, 'codEvento', $data->codigoEvento);
        $this->appendElement($evento, 'xMotivo', $data->motivo);
        $parent->appendChild($evento);
    }

    private function appendDesbloqueio(DOMElement $parent, DesbloqueioPorOficioData $data): void
    {
        $evento = $this->dom->createElement('e305103');
        $this->appendElement($evento, 'xDesc', $data->descricao);
        $this->appendElement($evento, 'CPFAgTrib', $data->cpfAgenteTributario);
        $this->appendElement($evento, 'idBloqOfic', $data->idBloqueioOficio);
        $parent->appendChild($evento);
    }

    private function appendElement(DOMElement $parent, string $name, ?string $value): void
    {
        if ($value === null) {
            return;
        }
        $text = SchemaText::forSchema($value);
        if ($text === null || $text === '') {
            return;
        }
        $el = $this->dom->createElement($name);
        $el->appendChild($this->dom->createTextNode($text));
        $parent->appendChild($el);
    }
}
