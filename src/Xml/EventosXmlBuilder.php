<?php

namespace Nfse\Xml;

use DOMDocument;
use DOMElement;
use Nfse\Dto\Nfse\PedRegEventoData;
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

        // Build Id for infPedReg: PRE + chNFSe + tipoEvento
        // nPedRegEvento foi removido do Id a partir de jan/2026 (TSIdPedRegEvt: PRE[0-9]{56})
        $ch = $data->infPedReg->chaveNfse;
        $tipo = $data->infPedReg->tipoEvento;
        $id = "PRE{$ch}{$tipo}";
        $inf->setAttribute('Id', $id);

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

        // nPedRegEvento não existe no schema XSD (nem v1.00 nem v1.01)
        // Após chNFSe vem direto o elemento do tipo de evento (e101101, etc.)
        if ($data->infPedReg->e101101) {
            $e = $this->dom->createElement('e101101');
            $this->appendElement($e, 'xDesc', $data->infPedReg->e101101->descricao);
            $this->appendElement($e, 'cMotivo', $data->infPedReg->e101101->codigoMotivo);
            $this->appendElement($e, 'xMotivo', $data->infPedReg->e101101->motivo);
            $inf->appendChild($e);
        }

        $root->appendChild($inf);

        $xml = $this->dom->saveXML($this->dom->documentElement, LIBXML_NOXMLDECL);

        return str_replace(["\n", "\r", "\t"], '', $xml);
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
