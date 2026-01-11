<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Serv;

/**
 * CCServData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCCServ
 */
class CCServData 
{
    /**
     * Código de tributação nacional do ISSQN:
     * Regra de formação - 6 dígitos numéricos sendo: 2 para Item (LC 116/2003), 2 para
     * Subitem (LC 116/2003) e 2 para Desdobro Nacional
     */
    public string $cTribNac;

    /**
     * Código de tributação municipal do ISSQN
     */
    public ?string $cTribMun = null;

    /**
     * Descrição completa do serviço prestado
     */
    public string $xDescServ;

    /**
     * Código NBS (Nomenclatura Brasileira de Serviços, Intangíveis e outras Operações que produzam
     * Variações no Patrimônio) correspondente ao serviço prestado
     */
    public ?string $cNBS = null;

    /**
     * Código interno do contribuinte
     */
    public ?string $cIntContrib = null;

}
