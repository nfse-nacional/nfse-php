<?php

namespace NFSe\Dto\V1_0_1\Common;

use NFSe\Dto\Attributes\MapFrom;

/**
 * EnderContribuinteCNC
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCEnderContribuinteCNC
 */
class EnderContribuinteCNC 
{
    /**
     * Código de endereçamento postal do estabelecimento do contribuinte
     */
    public string $CEP;

    /**
     * Número do estabelecimento no logradouro informado
     */
    public string $nro;

    /**
     * Informação complementar para identificação do endereço do contribuinte
     */
    public ?string $xCpl = null;

}
