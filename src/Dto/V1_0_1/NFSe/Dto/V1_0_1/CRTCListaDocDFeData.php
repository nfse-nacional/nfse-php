<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCListaDocDFeData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCListaDocDFe
 */
class CRTCListaDocDFeData 
{
    /**
     * Documento fiscal a que se refere a chaveDfe que seja um dos documentos do Repositório Nacional
     */
    public string $tipoChaveDFe;

    /**
     * Descrição da DF-e a que se refere a chaveDfe que seja um dos documentos do Repositório Nacional
     * Deve ser preenchido apenas quando "tipoChaveDFe = 9 (Outro)"
     */
    public ?string $xTipoChaveDFe = null;

    /**
     * Chave do Documento Fiscal eletrônico do repositório nacional referenciado para os casos de
     * operações já tributadas
     */
    public string $chaveDFe;

}
