<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

class TribMunData 
{
    /**
     * Não é permitido ao emitente informar se tratar de uma situação de exportação de serviço
     * (tribISSQN = 3) para os cenários 6, 10, 34, 38, 66, 80, conforme a planilha
     * "EXPORTACAO_EMISSÃO_NFS-e".
     */
    public ?string $tribISSQN = null;

    /**
     * Se, a tributação do ISSQN é igual à Exportação de serviço e Local da Prestação do Serviço
     * é no Brasil e o Serviço prestado tem incidência no Local do Estabelecimento do Prestador,
     * conforme LC 116/03,
     * ou
     * Se, a tributação do ISSQN é igual à Exportação de serviço e Local da Prestação do Serviço
     * é no Brasil e o Serviço prestado tem incidência no Local do Estabelecimento do Tomador, conforme
     * LC 116/03, e o Endereço do Tomador do serviço é no Exterior ou não informado,
     * Então,
     * é obrigatório informar o código do país onde ocorreu o resultado do serviço prestado.
     * 
     * obs: todos os cenários iguais a 2, 30, 58, 62, 72, 76, conforme a planilha
     * "EXPORTACAO_EMISSÃO_NFS-e".
     */
    public ?string $cPaisResult = null;

    /**
     * Obrigatório e informado somente quando o campo referente à tributação do ISSQN for igual a 2
     * (tribISSQN = 2).
     */
    public ?string $tpImunidade = null;

    /**
     * Não é permitido haver retenção do ISSQN (tpRetISSQN = 2 ou 3) quando o serviço prestado for
     * imune, exportação de serviço ou não incidência do ISSQN sobre o serviço prestado, ou seja, o
     * campo tpRetISSQ = 1 quando o campo referente à tributação do ISSQN (tribISSQN) é igual a "2 -
     * Imunidade, "3 - Exportação de Serviço" ou "4 - Não Incidência", (tribISSQN = 2, 3 ou 4).
     */
    public ?string $tpRetISSQN = null;

    /**
     * Não é permitido informar alíquota superior a 5%.
     */
    public ?string $pAliq = null;

    /**
     * Não é permitido informar suspensão da exigibilidade do ISSQN por decisão judicial ou
     * administrativa, quando o serviço prestado for imune, exportação de serviço ou não incidência
     * do ISSQN sobre o serviço prestado, ou seja, o campo referente à tributação do ISSQN (tribISSQN)
     * é igual a "2 - Imunidade, "3 - Exportação de Serviço" ou "4 - Não Incidência", (tribISSQN = 2,
     * 3 ou 4).
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMun\ExigSuspData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMun\ExigSuspData $exigSusp = null;

}
