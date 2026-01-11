<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CTribMunicipalData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCTribMunicipal
 */
class CTribMunicipalData 
{
    /**
     * Tributação do ISSQN sobre o serviço prestado:
     * 1 - Operação tributável;
     * 2 - Imunidade;
     * 3 - Exportação de serviço;
     * 4 - Não Incidência;
     */
    public string $tribISSQN;

    /**
     * Código do país onde se verficou o resultado da prestação do serviço para o caso de Exportação
     * de Serviço.(Tabela de Países ISO)
     */
    public ?string $cPaisResult = null;

    /**
     * Identificação da Imunidade do ISSQN – somente para o caso de Imunidade.
     * Tipos de Imunidades:
     * 0 - Imunidade (tipo não informado na nota de origem);
     * 1 - Patrimônio, renda ou serviços, uns dos outros (CF88, Art 150, VI, a);
     * 2 - Templos de qualquer culto (CF88, Art 150, VI, b);
     * 3 - Patrimônio, renda ou serviços dos partidos políticos, inclusive suas fundações,
     * das entidades sindicais dos trabalhadores, das instituições de educação e de assistência
     * social, sem fins lucrativos, atendidos os requisitos da lei (CF88, Art 150, VI, c);
     * 4 - Livros, jornais, periódicos e o papel destinado a sua impressão (CF88, Art 150,
     * VI, d);
     * 5 - Fonogramas e videofonogramas musicais produzidos no Brasil contendo obras musicais
     * ou literomusicais de autores brasileiros e/ou obras em geral interpretadas por artistas brasileiros
     * bem como os suportes materiais ou arquivos digitais que os contenham, salvo na etapa de replicação
     * industrial de mídias ópticas de leitura a laser.   (CF88, Art 150, VI, e);
     */
    public ?string $tpImunidade = null;

    /**
     * Informações para a suspensão da Exigibilidade do ISSQN
     */
    public ?\NFSe\Dto\V1_0_1\CExigSuspensaData $exigSusp = null;

    /**
     * Tributação do ISSQN sobre o serviço prestado:
     * 1 - Operação tributável;
     * 2 - Exportação de serviço;
     * 3 - Não Incidência;
     * 4 - Imunidade;
     */
    public ?\NFSe\Dto\V1_0_1\CBeneficioMunicipalData $BM = null;

    /**
     * Tipo de retencao do ISSQN:
     * 1 - Não Retido;
     * 2 - Retido pelo Tomador;
     * 3 - Retido pelo Intermediario;
     */
    public string $tpRetISSQN;

    /**
     * Valor da alíquota (%) do serviço prestado relativo ao município sujeito ativo (município de
     * incidência) do ISSQN.
     * Se o município de incidência pertence ao Sistema Nacional NFS-e a alíquota estará
     * parametrizada e, portanto, será fornecida pelo sistema.
     * Se o município de incidência não pertence ao Sistema Nacional NFS-e a alíquota não
     * estará parametrizada e, por isso, deverá ser fornecida pelo emitente.
     */
    public ?string $pAliq = null;

}
