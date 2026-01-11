<?php

namespace Nfse\Http\Client;

class CncClient extends AbstractNfseClient
{
    protected function getProductionUrl(): string
    {
        return 'https://adn.nfse.gov.br/cnc';
    }

    protected function getHomologationUrl(): string
    {
        return 'https://adn.producaorestrita.nfse.gov.br/cnc';
    }

    /**
     * CNC Consulta - Consulta dados atuais de um contribuinte
     */
    public function consultarContribuinte(string $cpfCnpj): array
    {
        return $this->get("/consulta/cad/{$cpfCnpj}");
    }

    /**
     * CNC Município - Baixa alterações no cadastro nacional via NSU
     */
    public function baixarAlteracoesCadastro(int $nsu): array
    {
        return $this->get("/municipio/cad/{$nsu}");
    }

    /**
     * CNC Recepção - Cadastra ou atualiza um contribuinte no CNC
     */
    public function atualizarContribuinte(array $dados): array
    {
        return $this->post('', $dados);
    }
}
