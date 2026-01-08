<?php

namespace Nfse\Support\DTO;

use Spatie\DataTransferObject\Caster;

class EnumCaster implements Caster
{
    /** @phpstan-ignore constructor.unusedParameter */
    public function __construct(
        array $types,
        private string $enumType,
    ) {}

    public function cast(mixed $value): mixed
    {
        if ($value instanceof $this->enumType) {
            return $value;
        }

        if (is_null($value)) {
            return null;
        }

        // Handle string to int conversion for int-backed enums
        $reflection = new \ReflectionEnum($this->enumType);
        if ($reflection->isBacked() && $reflection->getBackingType()->getName() === 'int' && is_string($value) && is_numeric($value)) {
            $value = (int) $value;
        }

        return $this->enumType::from($value);
    }
}
