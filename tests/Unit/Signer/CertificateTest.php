<?php

namespace Nfse\Tests\Unit\Signer;

use Exception;
use Nfse\Signer\Certificate;

it('throws exception for invalid password', function () {
    $pfxPath = __DIR__.'/../../fixtures/certs/test.pfx';
    $password = 'wrong_password';

    expect(fn () => new Certificate($pfxPath, $password))
        ->toThrow(Exception::class, 'Senha do certificado incorreta ou arquivo inválido/corrompido');
});

it('throws exception for expired certificate', function () {
    // Skipping this test as generating an expired PFX on the fly is complex and flaky across environments.
    // Ideally we should have a static expired.pfx fixture.
})->skip('Requires a pre-generated expired PFX file');

it('throws exception when certificate file not found', function () {
    expect(fn () => new Certificate('non_existent.pfx', 'password'))
        ->toThrow(Exception::class, 'Certificado não encontrado');
});

it('can get certificate data and sign content', function () {
    $pfxPath = __DIR__.'/../../fixtures/certs/test.pfx';
    $password = '1234'; // Assuming 1234 is the password for test.pfx based on ContribuinteServiceTest

    $cert = new Certificate($pfxPath, $password);

    expect($cert->getPrivateKey())->toBeString()
        ->and($cert->getCertificate())->toBeString()
        ->and($cert->getCleanCertificate())->toBeString()
        ->and($cert->getCleanCertificate())->not->toContain('BEGIN CERTIFICATE')
        ->and($cert->sign('content'))->toBeString();
});

it('fromContent loads certificate from raw bytes', function () {
    $pfxContent = file_get_contents(__DIR__.'/../../fixtures/certs/test.pfx');

    $cert = Certificate::fromContent($pfxContent, '1234');

    expect($cert->getPrivateKey())->toBeString()
        ->and($cert->getCertificate())->toBeString()
        ->and($cert->getCleanCertificate())->not->toContain('BEGIN CERTIFICATE')
        ->and($cert->sign('content'))->toBeString();
});

it('fromContent produces the same output as fromPath', function () {
    $pfxPath = __DIR__.'/../../fixtures/certs/test.pfx';
    $pfxContent = file_get_contents($pfxPath);

    $certFromPath    = new Certificate($pfxPath, '1234');
    $certFromContent = Certificate::fromContent($pfxContent, '1234');

    expect($certFromContent->getCertificate())->toBe($certFromPath->getCertificate())
        ->and($certFromContent->getCleanCertificate())->toBe($certFromPath->getCleanCertificate());
});

it('fromContent throws on wrong password', function () {
    $pfxContent = file_get_contents(__DIR__.'/../../fixtures/certs/test.pfx');

    expect(fn () => Certificate::fromContent($pfxContent, 'wrong_password'))
        ->toThrow(Exception::class, 'Senha do certificado incorreta ou arquivo inválido/corrompido');
});

it('fromContent throws on invalid pfx bytes', function () {
    expect(fn () => Certificate::fromContent('not-a-pfx-file', 'any'))
        ->toThrow(Exception::class, 'Senha do certificado incorreta ou arquivo inválido/corrompido');
});
