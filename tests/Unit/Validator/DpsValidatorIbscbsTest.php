<?php

namespace Nfse\Tests\Unit\Validator;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Validator\DpsValidator;

function validarDpsComIbscbs(array $ibscbs, array $sobrescritas = []): array
{
    $infDps = array_replace([
        'tpAmb' => 2,
        'dhEmi' => '2026-03-10T10:00:00-03:00',
        'verAplic' => '1.0',
        'serie' => '1',
        'nDPS' => '1001',
        'dCompet' => '2026-03-10',
        'tpEmit' => 1,
        'cLocEmi' => '3550308',
        'prest' => [
            'CNPJ' => '12345678000199',
            'xNome' => 'Prestador Exemplo Ltda',
        ],
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '010201',
                'xDescServ' => 'Analise de sistemas',
                'cNBS' => '112011000',
            ],
        ],
        'valores' => [
            'vServPrest' => ['vServ' => 1000.00],
            'trib' => ['tribMun.tribISSQN' => 1],
        ],
        'IBSCBS' => $ibscbs,
    ], $sobrescritas);

    return (new DpsValidator)->validate(new DpsData([
        '@attributes' => ['versao' => '1.01'],
        'infDPS' => $infDps,
    ]))->errors;
}

function ibscbsValido(array $sobrescritas = []): array
{
    return array_replace([
        'finNFSe' => '0',
        'cIndOp' => '010101',
        'indDest' => 0,
        'valores' => [
            'trib' => [
                'gIBSCBS' => [
                    'CST' => '000',
                    'cClassTrib' => '000001',
                ],
            ],
        ],
    ], $sobrescritas);
}

it('accepts a consistent ibscbs group', function () {
    expect(validarDpsComIbscbs(ibscbsValido()))->toBeEmpty();
});

it('rejects ibscbs before the 2026 competence', function () {
    $errors = validarDpsComIbscbs(ibscbsValido(), ['dCompet' => '2025-12-31']);

    expect($errors)->toContain('As informações de IBS/CBS só podem ser declaradas a partir da data de competência 01/01/2026.');
});

it('requires the nbs item when ibscbs is informed', function () {
    $errors = validarDpsComIbscbs(ibscbsValido(), [
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '010201',
                'xDescServ' => 'Analise de sistemas',
            ],
        ],
    ]);

    expect($errors)->toContain('O item da NBS é obrigatório quando o grupo de informações de IBS/CBS é informado.');
});

it('requires referenced nfse when the operation type is 2 or 3', function () {
    $errors = validarDpsComIbscbs(ibscbsValido(['tpOper' => 2]));

    expect($errors)->toContain('O grupo de NFS-e referenciadas é obrigatório quando o tipo de operação for 2 ou 3.');
});

it('rejects a destinatario when the destination indicator is not 1', function () {
    $errors = validarDpsComIbscbs(ibscbsValido([
        'dest' => [
            'CNPJ' => '98765432000188',
            'xNome' => 'Destinatario Exemplo Ltda',
        ],
    ]));

    expect($errors)->toContain('O destinatário do serviço só deve ser identificado quando o indicador de destinatário for 1.');
});

it('rejects a cClassTrib outside the informed cst group', function () {
    $errors = validarDpsComIbscbs(ibscbsValido([
        'valores' => [
            'trib' => [
                'gIBSCBS' => [
                    'CST' => '200',
                    'cClassTrib' => '000001',
                ],
            ],
        ],
    ]));

    expect($errors)->toContain('O código de classificação tributária informado não pertence ao grupo do CST de IBS/CBS informado.');
});

it('validates the reimbursement documents', function () {
    $errors = validarDpsComIbscbs(ibscbsValido([
        'valores' => [
            'gReeRepRes' => [
                'documentos' => [
                    'docOutro' => ['nDoc' => '55', 'xDoc' => 'Recibo'],
                    'dtEmiDoc' => '2026-01-10',
                    'dtCompDoc' => '2026-02-10',
                    'tpReeRepRes' => '01',
                    'xTpReeRepRes' => 'Descricao indevida',
                    'vlrReeRepRes' => 1500.00,
                ],
            ],
            'trib' => [
                'gIBSCBS' => [
                    'CST' => '000',
                    'cClassTrib' => '000001',
                ],
            ],
        ],
    ]));

    expect($errors)->toContain('A descrição do tipo de reembolso, repasse e ressarcimento só deve ser informada quando o tipo for 99.')
        ->toContain('A data de emissão do documento de reembolso deve ser igual ou posterior à sua data de competência.')
        ->toContain('O valor de reembolso, repasse e ressarcimento deve ser menor ou igual ao valor do serviço prestado.');
});
