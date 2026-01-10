<?php

namespace Nfse\Validator;

use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPSData;
use Nfse\Enums\EmitenteDPS;

class DpsValidator
{
    public function validate(DPSData $dps): ValidationResult
    {
        $errors = [];
        $infDps = $dps->infDPS;

        if ($infDps === null) {
            return ValidationResult::failure(['InfDPSData is required.']);
        }

        $this->validatePrestador($infDps, $errors);
        $this->validateTomador($infDps, $errors);
        $this->validateValores($infDps, $errors);
        $this->validateServico($infDps, $errors);

        if (count($errors) > 0) {
            return ValidationResult::failure($errors);
        }

        return ValidationResult::success();
    }

    private function validatePrestador(InfDPSData $infDps, array &$errors): void
    {
        $prestador = $infDps->prest;
        $tpEmit = $infDps->tpEmit;

        if ($prestador === null) {
            $errors[] = 'Prestador data is required.';

            return;
        }

        // Rule: If Prestador is NOT the emitter, address is required.
        // Schema Rule E0129
        if ($tpEmit !== (string) EmitenteDPS::Prestador->value) {
            if ($prestador->end === null) {
                $errors[] = 'Endereço do prestador é obrigatório quando o prestador não for o emitente.';
            }
        }

        // Rule: If Prestador is the emitter, address should NOT be informed (Schema Rule E0128)
        // However, usually we just ignore it or warn. For strict validation, we might error.
        // Let's stick to "Required" checks for now as per user request.
    }

    private function validateTomador(InfDPSData $infDps, array &$errors): void
    {
        $tomador = $infDps->toma;

        if ($tomador === null) {
            return;
        }

        // User Rule: "se o tomador for identificado o endereço dele é obg"
        $isIdentified = $tomador->CPF || $tomador->CNPJ || $tomador->NIF;

        if ($isIdentified) {
            if ($tomador->end === null) {
                $errors[] = 'Endereço do tomador é obrigatório quando o tomador é identificado.';

                return;
            }

            if ($tomador->NIF !== null) {
                if ($tomador->end->endExt === null) {
                    $errors[] = 'Endereço no exterior do tomador é obrigatório quando identificado por NIF.';
                }
            } else {
                if ($tomador->end->endNac === null || $tomador->end->endNac->cMun === null) {
                    $errors[] = 'Código do município do tomador é obrigatório para endereço nacional.';
                }
            }
        }
    }

    private function validateValores(InfDPSData $infDps, array &$errors): void
    {
        $valores = $infDps->valores;
        if ($valores === null) {
            return;
        }

        $vServ = $valores->vServPrest ? (float)($valores->vServPrest->vServ ?? 0) : 0.0;
        
        $vDescIncond = 0.0;
        $vDescCond = 0.0;
        
        if ($valores->vDescCondIncond) {
            $vDescIncond = (float)($valores->vDescCondIncond->vDescIncond ?? 0);
            $vDescCond = (float)($valores->vDescCondIncond->vDescCond ?? 0);
        }

        // Rule 307: vDescIncond < vServ
        if ($vDescIncond > 0 && $vDescIncond >= $vServ) {
            $errors[] = 'O valor do desconto incondicionado deve ser menor que o valor do serviço.';
        }

        // Rule 309: vDescCond < vServ
        if ($vDescCond > 0 && $vDescCond >= $vServ) {
            $errors[] = 'O valor do desconto condicionado deve ser menor que o valor do serviço.';
        }

        // Rule 303: vServ >= descIncond + vDR + vRedBCBM
        $vDR = $valores->vDedRed ? (float)($valores->vDedRed->vDedRed ?? 0) : 0.0;
        $vRedBCBM = 0.0;
        if ($valores->trib && $valores->trib->tribMun && $valores->trib->tribMun->bm) {
             $vRedBCBM = (float)($valores->trib->tribMun->bm->vRedBCBM ?? 0);
        }

        if ($vServ < ($vDescIncond + $vDR + $vRedBCBM)) {
            $errors[] = 'O valor do serviço deve ser maior ou igual ao somatório dos valores informados para Desconto Incondicionado, Deduções/Reduções e Benefício Municipal.';
        }
    }

    private function validateServico(InfDPSData $infDps, array &$errors): void
    {
        $servico = $infDps->serv;
        if ($servico === null) {
            return;
        }

        $cTribNac = $servico->cServ?->cTribNac;

        // Rule 260: obra is required for construction services
        $constructionCodes = [
            '070201', '070202', '070401', '070501', '070502',
            '070601', '070602', '070701', '070801', '071701', '071901',
        ];

        if (in_array($cTribNac, $constructionCodes) && $servico->obra === null) {
            $errors[] = 'O grupo de informações de obra é obrigatório para o serviço informado.';
        }

        // Rule 276: atvEvento is required for item 12
        if (str_starts_with($cTribNac ?? '', '12') && $servico->atvEvento === null) {
            $errors[] = 'O grupo de informações de Atividade/Evento é obrigatório para o serviço informado.';
        }
    }
}
