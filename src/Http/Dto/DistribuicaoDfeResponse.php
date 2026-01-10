<?php

namespace Nfse\Http\Dto;

use CuyZ\Valinor\Mapper\Source\Source;

class DistribuicaoDfeResponse 
{
    #[Source('tpAmb')]
    public ?string $tipoAmbiente = null;

    #[Source('verAplic')]
    public ?string $versaoAplicativo = null;

    #[Source('dhProc')]
    public ?string $dataHoraProcessamento = null;

    #[Source('ultNSU')]
    public ?int $ultimoNsu = null;

    #[Source('maiorNSU')]
    public ?int $maiorNsu = null;

    public array $alertas = [];

    public array $erros = [];

    #[Source('lNSU')]
    public array $listaNsu = [];
}
