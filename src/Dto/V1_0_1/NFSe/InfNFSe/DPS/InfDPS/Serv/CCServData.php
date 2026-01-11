<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\Serv;

/**
 * CCServData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCCServ
 */
class CCServData 
{
    /**
     * Código de tributação nacional do ISSQN, nos termos da LC 116/2003, conforme aba
     * MUN.INCID_INFO.SERV. do ANEXO I
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
     * Código NBS correspondente ao serviço prestado, seguindo a versão 2.0, conforme Anexo B
     */
    public string $cNBS;

    /**
     * Código interno do contribuinte
     */
    public ?string $cIntContrib = null;

}
