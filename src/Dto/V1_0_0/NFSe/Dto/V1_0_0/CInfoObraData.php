<?php

namespace NFSe\Dto\V1_0_0;

/**
 * CInfoObraData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoObra
 */
class CInfoObraData 
{
    /**
     * Número de identificação da obra.
     * Cadastro Nacional de Obras (CNO) ou Cadastro Específico do INSS (CEI).
     */
    public string $cObra;

    /**
     * Inscrição imobiliária fiscal (código fornecido pela Prefeitura Municipal para a identificação
     * da obra ou para fins de recolhimento do IPTU)
     */
    public string $inscImobFisc;

    /**
     * Grupo de informações do endereço da obra do serviço prestado
     */
    public \NFSe\Dto\V1_0_0\CEnderecoSimplesData $end;

}
