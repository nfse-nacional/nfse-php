<?php

namespace Nfse\Tests\Unit\Dto;

use Nfse\Nfse\Dto\InfDpsData;
use Illuminate\Validation\ValidationException;

it('fails validation when required fields are missing', function () {
    try {
        InfDpsData::validate([
            'tpAmb' => 1,
        ]);
        echo "Validation passed unexpectedly" . PHP_EOL;
    } catch (ValidationException $e) {
        echo "Validation failed as expected" . PHP_EOL;
        throw $e;
    } catch (\Throwable $e) {
        echo "Caught unexpected exception: " . get_class($e) . " - " . $e->getMessage() . PHP_EOL;
        throw $e;
    }
})->throws(ValidationException::class);

it('passes validation when all required fields are present', function () {
    $data = [
        '@Id' => 'DPS123',
        'tpAmb' => 1,
        'dhEmi' => '2023-10-27T10:00:00-03:00',
        'verAplic' => '1.0',
        'serie' => '1',
        'nDPS' => '1001',
        'dCompet' => '2023-10-27',
        'tpEmit' => 1,
        'cLocEmi' => '3550308',
    ];

    $infDps = InfDpsData::validateAndCreate($data);

    expect($infDps)->toBeInstanceOf(InfDpsData::class)
        ->and($infDps->id)->toBe('DPS123');
});
