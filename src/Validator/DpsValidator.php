<?php

namespace Nfse\Validator;

use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Enums\EmitenteDPS;
use Nfse\Enums\IndicadorDestinatario;
use Nfse\Enums\TipoReembolsoRepasseRessarcimento;

class DpsValidator
{
    public function validate(DpsData $dps): ValidationResult
    {
        $errors = [];
        $infDps = $dps->infDps;

        if ($infDps === null) {
            return ValidationResult::failure(['InfDpsData is required.']);
        }

        $this->validateVersao($dps, $errors);
        $this->validatePrestador($infDps, $errors);
        $this->validateTomador($infDps, $errors);
        $this->validateValores($infDps, $errors);
        $this->validateServico($infDps, $errors);
        $this->validateIbscbs($infDps, $errors);

        if (count($errors) > 0) {
            return ValidationResult::failure($errors);
        }

        return ValidationResult::success();
    }

    /**
     * TVerNFSe do schema: padrão 1.00|1.01, atributo obrigatório.
     */
    private function validateVersao(DpsData $dps, array &$errors): void
    {
        if ($dps->versao === null || $dps->versao === '') {
            $errors[] = 'O atributo versao da DPS é obrigatório (1.00 ou 1.01).';

            return;
        }

        if (! preg_match('/^1\.0[01]$/', $dps->versao)) {
            $errors[] = 'A versão da DPS deve ser 1.00 ou 1.01 conforme o schema (TVerNFSe).';
        }
    }

    private function validatePrestador(InfDpsData $infDps, array &$errors): void
    {
        $prestador = $infDps->prestador;
        $tpEmit = $infDps->tipoEmitente;

        if ($prestador === null) {
            $errors[] = 'Prestador data is required.';

            return;
        }

        // Rule: If Prestador is NOT the emitter, address is required.
        // Schema Rule E0129
        if ($tpEmit !== EmitenteDPS::Prestador) {
            if ($prestador->endereco === null) {
                $errors[] = 'Endereço do prestador é obrigatório quando o prestador não for o emitente.';
            }
        }

        // Rule: If Prestador is the emitter, address should NOT be informed (Schema Rule E0128)
        // However, usually we just ignore it or warn. For strict validation, we might error.
        // Let's stick to "Required" checks for now as per user request.
    }

    private function validateTomador(InfDpsData $infDps, array &$errors): void
    {
        $tomador = $infDps->tomador;

        if ($tomador === null) {
            return;
        }

        // User Rule: "se o tomador for identificado o endereço dele é obg"
        $isIdentified = $tomador->cpf || $tomador->cnpj || $tomador->nif;

        if ($isIdentified) {
            if ($tomador->endereco === null) {
                $errors[] = 'Endereço do tomador é obrigatório quando o tomador é identificado.';

                return;
            }

            if ($tomador->nif !== null) {
                if ($tomador->endereco->enderecoExterior === null) {
                    $errors[] = 'Endereço no exterior do tomador é obrigatório quando identificado por NIF.';
                }
            } else {
                if ($tomador->endereco->codigoMunicipio === null) {
                    $errors[] = 'Código do município do tomador é obrigatório para endereço nacional.';
                }
            }
        }
    }

    private function validateValores(InfDpsData $infDps, array &$errors): void
    {
        $valores = $infDps->valores;
        if ($valores === null) {
            return;
        }

        $vServ = $valores->valorServicoPrestado ? ($valores->valorServicoPrestado->valorServico ?? 0) : 0;
        $vDescIncond = $valores->desconto ? ($valores->desconto->valorDescontoIncondicionado ?? 0) : 0;
        $vDescCond = $valores->desconto ? ($valores->desconto->valorDescontoCondicionado ?? 0) : 0;

        // Rule 307: vDescIncond < vServ
        if ($vDescIncond > 0 && $vDescIncond >= $vServ) {
            $errors[] = 'O valor do desconto incondicionado deve ser menor que o valor do serviço.';
        }

        // Rule 309: vDescCond < vServ
        if ($vDescCond > 0 && $vDescCond >= $vServ) {
            $errors[] = 'O valor do desconto condicionado deve ser menor que o valor do serviço.';
        }

        // Rule 303: vServ >= descIncond + vDR + vRedBCBM
        $vDR = $valores->deducaoReducao ? ($valores->deducaoReducao->valorDeducaoReducao ?? 0) : 0;
        $vRedBCBM = 0;
        if ($valores->tributacao && $valores->tributacao->beneficioMunicipal) {
            $vRedBCBM = $valores->tributacao->beneficioMunicipal->valorReducaoBcBm ?? 0;
        }

        if ($vServ < ($vDescIncond + $vDR + $vRedBCBM)) {
            $errors[] = 'O valor do serviço deve ser maior ou igual ao somatório dos valores informados para Desconto Incondicionado, Deduções/Reduções e Benefício Municipal.';
        }
    }

    private function validateServico(InfDpsData $infDps, array &$errors): void
    {
        $servico = $infDps->servico;
        if ($servico === null) {
            return;
        }

        $cTribNac = $servico->codigoServico?->codigoTributacaoNacional;

        // Rule 260: obra is required for construction services
        $constructionCodes = [
            '070201', '070202', '070401', '070501', '070502',
            '070601', '070602', '070701', '070801', '071701', '071901',
        ];

        if (in_array($cTribNac, $constructionCodes) && $servico->obra === null) {
            $errors[] = 'O grupo de informações de obra é obrigatório para o serviço informado.';
        }

        // Rule 276: atvEvento is required for item 12
        if (str_starts_with($cTribNac ?? '', '12') && $servico->atividadeEvento === null) {
            $errors[] = 'O grupo de informações de Atividade/Evento é obrigatório para o serviço informado.';
        }
    }

    private function validateIbscbs(InfDpsData $infDps, array &$errors): void
    {
        $ibscbs = $infDps->ibscbs;
        if ($ibscbs === null) {
            return;
        }

        // Rule 542: IBS/CBS só pode ser declarado a partir da competência 01/01/2026
        if ($infDps->dataCompetencia !== null && $infDps->dataCompetencia < '2026-01-01') {
            $errors[] = 'As informações de IBS/CBS só podem ser declaradas a partir da data de competência 01/01/2026.';
        }

        // Rule 324: cNBS é obrigatório quando o grupo de IBS/CBS é informado
        if ($infDps->servico?->codigoServico?->codigoNbs === null) {
            $errors[] = 'O item da NBS é obrigatório quando o grupo de informações de IBS/CBS é informado.';
        }

        // Rule 549: gRefNFSe é obrigatório quando tpOper = 2 ou 3
        if ($ibscbs->tipoOperacao?->exigeNfseReferenciada() && empty($ibscbs->chavesNfseReferenciadas)) {
            $errors[] = 'O grupo de NFS-e referenciadas é obrigatório quando o tipo de operação for 2 ou 3.';
        }

        // Rule 554: o destinatário só deve ser identificado quando indDest = 1
        if ($ibscbs->destinatario !== null && $ibscbs->indicadorDestinatario !== IndicadorDestinatario::DestinatarioDiverso) {
            $errors[] = 'O destinatário do serviço só deve ser identificado quando o indicador de destinatário for 1.';
        }

        // Rule 627: os 3 primeiros dígitos do cClassTrib devem corresponder ao CST
        if ($ibscbs->cst !== null && $ibscbs->codigoClassificacaoTributaria !== null
            && ! str_starts_with($ibscbs->codigoClassificacaoTributaria, $ibscbs->cst)) {
            $errors[] = 'O código de classificação tributária informado não pertence ao grupo do CST de IBS/CBS informado.';
        }

        $vServ = $infDps->valores?->valorServicoPrestado?->valorServico ?? 0;

        foreach ($ibscbs->documentosReembolso ?? [] as $documento) {
            // Rule 621: xTpReeRepRes só deve ser informado quando tpReeRepRes = 99
            if ($documento->descricaoTipoReembolso !== null && $documento->tipoReembolso !== TipoReembolsoRepasseRessarcimento::Outros) {
                $errors[] = 'A descrição do tipo de reembolso, repasse e ressarcimento só deve ser informada quando o tipo for 99.';
            }

            // Rule 618/619: a data de emissão deve ser igual ou posterior à data de competência
            if ($documento->dataEmissaoDocumento !== null && $documento->dataCompetenciaDocumento !== null
                && $documento->dataEmissaoDocumento < $documento->dataCompetenciaDocumento) {
                $errors[] = 'A data de emissão do documento de reembolso deve ser igual ou posterior à sua data de competência.';
            }

            // Rule 622: o valor do reembolso deve ser menor ou igual ao valor do serviço prestado
            if ($documento->valorReembolso !== null && $documento->valorReembolso > $vServ) {
                $errors[] = 'O valor de reembolso, repasse e ressarcimento deve ser menor ou igual ao valor do serviço prestado.';
            }
        }
    }
}
