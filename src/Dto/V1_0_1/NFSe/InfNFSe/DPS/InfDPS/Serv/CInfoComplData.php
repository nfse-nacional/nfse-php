<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\Serv;

/**
 * CInfoComplData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCInfoCompl
 */
class CInfoComplData 
{
    /**
     * Identificador de Documento de Responsabilidade Técnica: ART, RRT, DRT, Outros.
     */
    public ?string $idDocTec = null;

    /**
     * Chave da nota, número identificador da nota, número do contrato ou outro identificador de
     * documento emitido pelo prestador de serviços, que subsidia a emissão dessa nota pelo tomador do
     * serviço ou intermediário (preenchimento obrigatório caso a nota esteja sendo emitida pelo Tomador
     * ou intermediário do serviço).
     */
    public ?string $docRef = null;

    /**
     * Número do  pedido/ordem de compra/ordem de serviço/projeto que autorize a prestação do serviço
     * em operações B2B - Informação de interesse do tomador do serviço para controle e gestão da
     * Negociação
     */
    public ?string $xPed = null;

    /**
     * Grupo de itens do pedido/ordem de compra/ordem de serviço/projeto
     */
    public ?\NFSe\Dto\V1_0_1\CInfoItemPedData $gItemPed = null;

    /**
     * Informações complementares
     */
    public ?string $xInfComp = null;

}
