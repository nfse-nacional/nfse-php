<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCInfoImovel
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCInfoImovel
 */
class RTCInfoImovel 
{
    /**
     * Inscrição imobiliária fiscal (código fornecido pela Prefeitura Municipal para a identificação
     * da obra ou para fins de recolhimento do IPTU)
     */
    public ?string $inscImobFisc = null;

    /**
     * Código do Cadastro Imobiliário Brasileiro - CIB
     */
    public string $cCIB;

    /**
     * Grupo de informações do endereço da obra do serviço prestado
     */
    public \NFSe\Dto\V1_0_1\DPS\InfDPS\Serv\InfoObra\EnderObraEvento $end;

}
