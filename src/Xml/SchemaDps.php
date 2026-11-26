<?php

namespace Nfse\Xml;

use InvalidArgumentException;
use Nfse\Enums\TipoAmbiente;

/**
 * Pacote de esquemas da DPS. Cada caso aponta para uma pasta em references/schemas.
 * Quem não informa a versão usa o ambiente: homologação no pacote novo, produção no atual.
 */
enum SchemaDps: string
{
    case Producao = '20261020';
    case Homologacao = '20261124';

    public static function padrao(mixed $ambiente): self
    {
        if ($ambiente instanceof TipoAmbiente) {
            return $ambiente === TipoAmbiente::Homologacao ? self::Homologacao : self::Producao;
        }

        if ((string) $ambiente === TipoAmbiente::Homologacao->value) {
            return self::Homologacao;
        }

        return self::Producao;
    }

    public static function resolver(self|string|null $schema, mixed $ambiente = null): self
    {
        if ($schema instanceof self) {
            return $schema;
        }

        if ($schema === null || $schema === '') {
            return self::padrao($ambiente);
        }

        $encontrado = self::tryFrom($schema);
        if ($encontrado === null) {
            throw new InvalidArgumentException('Schema não encontrado: '.$schema);
        }

        return $encontrado;
    }

    public function pasta(): string
    {
        $pasta = dirname(__DIR__, 2).'/references/schemas/'.$this->value;
        if (! is_dir($pasta)) {
            throw new InvalidArgumentException('Schema não encontrado: '.$this->value);
        }

        return $pasta;
    }
}
