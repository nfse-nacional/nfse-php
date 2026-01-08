<?php

namespace Nfse\Dto;

use ReflectionClass;
use ReflectionProperty;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

abstract class Dto extends DataTransferObject
{
    public function __construct(...$args)
    {
        // Se o primeiro argumento é um array, usamos ele como input (estilo antigo/Spatie)
        if (isset($args[0]) && is_array($args[0])) {
            $input = $args[0];
        } else {
            // Caso contrário, assumimos que os argumentos passados (named ou não) são o input
            $input = $args;
        }

        // Normaliza o input (permite usar nomes de propriedades originais)
        $input = $this->normalizeInput($input);

        // Chama o construtor pai passando o array normalizado como ÚNICO argumento
        // Isso evita erros com chaves inválidas para named arguments (ex: '@attributes')
        // e garante que o DataTransferObject trate como um array de propriedades
        parent::__construct($input);
    }

    protected function normalizeInput(array $input): array
    {
        $class = new ReflectionClass($this);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $propName = $property->getName();

            // Se o input tem a chave com o nome da propriedade
            if (array_key_exists($propName, $input)) {
                $attributes = $property->getAttributes(MapFrom::class);

                if (count($attributes) > 0) {
                    $mapFrom = $attributes[0]->newInstance();
                    $mappedName = $mapFrom->name;

                    // Se o mappedName usa dot notation, precisamos expandir
                    if (str_contains($mappedName, '.')) {
                        // Verifica se já existe valor no caminho mapeado
                        if (! $this->hasDotNotation($input, $mappedName)) {
                            $this->setDotNotation($input, $mappedName, $input[$propName]);
                        }
                    } else {
                        // Se não existe a chave mapeada, define ela
                        if (! array_key_exists($mappedName, $input)) {
                            $input[$mappedName] = $input[$propName];
                        }
                    }
                }
            }
        }

        return $input;
    }

    protected function hasDotNotation(array $array, string $key): bool
    {
        $keys = explode('.', $key);
        $current = $array;

        foreach ($keys as $k) {
            if (! is_array($current) || ! array_key_exists($k, $current)) {
                return false;
            }
            $current = $current[$k];
        }

        return true;
    }

    protected function setDotNotation(array &$array, string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $current = &$array;

        foreach ($keys as $i => $k) {
            if ($i === count($keys) - 1) {
                $current[$k] = $value;
            } else {
                if (! isset($current[$k]) || ! is_array($current[$k])) {
                    $current[$k] = [];
                }
                $current = &$current[$k];
            }
        }
    }
}
