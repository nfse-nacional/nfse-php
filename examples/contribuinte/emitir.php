<?php

use Nfse\Dto\Nfse\CodigoServicoData;
use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Dto\Nfse\LocalPrestacaoData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\ServicoData;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Dto\Nfse\TributacaoData;
use Nfse\Dto\Nfse\ValoresData;
use Nfse\Dto\Nfse\ValorServicoPrestadoData;
use Nfse\Support\IdGenerator;

/** @var \Nfse\Nfse $nfse */
$nfse = require_once __DIR__ . '/../bootstrap.php';

try {
    $cnpjPrestador = '12345678000199';
    // $codigoMunicipio já vem do bootstrap.php
    $serie = '1';
    $numero = '100';

    $idDps = IdGenerator::generateDpsId(
        cpfCnpj: $cnpjPrestador,
        codIbge: $codigoMunicipio,
        serieDps: $serie,
        numDps: $numero
    );

    $dps = new DpsData(
        versao: '1.0.0',
        infDps: new InfDpsData(
            id: $idDps,
            tipoAmbiente: 2, // Homologação
            dataEmissao: date('Y-m-d\TH:i:s'),
            versaoAplicativo: 'SDK-PHP-1.0',
            serie: $serie,
            numeroDps: $numero,
            dataCompetencia: date('Y-m-d'),
            tipoEmitente: 1, // Prestador
            codigoLocalEmissao: $codigoMunicipio,
            prestador: new PrestadorData(
                cnpj: $cnpjPrestador,
                inscricaoMunicipal: '123456',
                nome: 'Empresa de Teste'
            ),
            tomador: new TomadorData(
                cnpj: '98765432000100',
                nome: 'Cliente de Teste'
            ),
            servico: new ServicoData(
                localPrestacao: new LocalPrestacaoData(
                    codigoLocalPrestacao: $codigoMunicipio,
                    codigoPaisPrestacao: 'BR'
                ),
                codigoServico: new CodigoServicoData(
                    codigoTributacaoNacional: '01.01'
                )
            ),
            valores: new ValoresData(
                valorServicoPrestado: new ValorServicoPrestadoData(
                    valorServico: 100.00
                ),
                tributacao: new TributacaoData(
                    tributacaoIssqn: 1,
                    tipoImunidade: null,
                    tipoRetencaoIssqn: 1,
                    tipoSuspensao: null,
                    numeroProcessoSuspensao: null,
                    beneficioMunicipal: null,
                    cstPisCofins: '01'
                )
            )
        )
    );

    echo "Emitindo NFS-e para a DPS: $idDps...\n";
    
    $nfseData = $nfse->contribuinte()->emitir($dps);
    
    echo "NFS-e emitida com sucesso!\n";
    echo "Chave de Acesso: " . $nfseData->infNfse->id . "\n";
    
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
