<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest;

class RegTribData 
{
    /**
     * Opção de situação perante o Simples Nacional do prestador, informada na DPS, não está de
     * acordo com o cadastro Simples Nacional na data de competência informada na DPS.
     * Se CNPJ do prestador não consta no cadastro então opSimpNac é igual a 1;
     */
    public ?string $opSimpNac = null;

    /**
     * O regime de apuração dos tributos para o optante do Simples Nacional (ME/EPP) não pode ser
     * preenchido quando o prestador de serviço não for optante do simples nacional ou for MEI, ou seja,
     * o campo opSimpNac = 1 ou 2.
     */
    public ?string $regApTribSN = null;

    /**
     * Não é permitido informar Regime Especial de Tributação, ou seja, regEspTrib deve ser igual a 0
     * (Nenhum), quando o serviço prestado for imune, exportação de serviço ou não incidência do
     * ISSQN sobre o serviço prestado, ou seja, o campo referente à tributação do ISSQN (tribISSQN) é
     * igual a "2 - Imunidade, "3 - Exportação de Serviço" ou "4 - Não Incidência",
     * (tribISSQN = 2, 3 ou 4).
     */
    public ?string $regEspTrib = null;

}
