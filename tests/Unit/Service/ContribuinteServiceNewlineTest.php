<?php

use Nfse\Dto\Http\EmissaoNfseResponse;
use Nfse\Dto\Nfse\DpsData;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Contracts\SefinNacionalInterface;
use Nfse\Http\NfseContext;
use Nfse\Service\ContribuinteService;
use Nfse\Signer\Certificate;
use Nfse\Signer\SignerInterface;
use Nfse\Support\IdGenerator;

it('removes newlines from signed xml before emission', function () {
    $context = new NfseContext(
        TipoAmbiente::Homologacao,
        __DIR__.'/../../fixtures/certs/test.pfx',
        '1234'
    );

    $sefinClientMock = test()->createMock(SefinNacionalInterface::class);
    $adnClientMock = test()->createMock(AdnClient::class);

    // Create a partial mock or subclass to override createSigner
    $service = new class($context) extends ContribuinteService
    {
        public $signerMock;

        protected function createSigner(Certificate $certificate): SignerInterface
        {
            return $this->signerMock;
        }
    };

    // Inject mocks into the service
    $reflection = new ReflectionClass(ContribuinteService::class);
    $sefinProperty = $reflection->getProperty('sefinClient');
    $sefinProperty->setValue($service, $sefinClientMock);

    $adnProperty = $reflection->getProperty('adnClient');
    $adnProperty->setValue($service, $adnClientMock);

    // Setup the mock signer to return XML WITHOUT newlines (matching real XmlSigner behavior)
    $signedXmlWithoutNewlines = '<SignedXML><Content>Test</Content></SignedXML>';
    $signerMock = test()->createMock(SignerInterface::class);
    $signerMock->method('sign')->willReturn($signedXmlWithoutNewlines);

    $service->signerMock = $signerMock;

    // Setup input data
    $idDps = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1');
    $dpsData = new DpsData([
        '@attributes' => ['versao' => '1.00'],
        'infDPS' => [
            '@attributes' => ['Id' => $idDps],
            'tpAmb' => 2,
            'dhEmi' => '2023-10-27T10:00:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1',
            'dCompet' => '2023-10-27',
            'tpEmit' => 1,
            'cLocEmi' => '3550308',
        ],
    ]);

    $responseXml = '<?xml version="1.0" encoding="UTF-8"?><NFSe><infNFSe><nNFSe>100</nNFSe></infNFSe></NFSe>';
    $responseDto = new EmissaoNfseResponse([
        'tpAmb' => 2,
        'verAplic' => '1.0',
        'dhProc' => '2023-10-27T10:00:00',
        'idDPS' => 'DPS123',
        'chAcesso' => 'CHAVE123',
        'nfseXmlGZipB64' => base64_encode(gzencode($responseXml)),
    ]);

    // Expectation: emitirNfse should receive payload WITHOUT newlines
    $sefinClientMock->expects(test()->once())
        ->method('emitirNfse')
        ->with(test()->callback(function ($payload) use ($signedXmlWithoutNewlines) {
            $decoded = gzdecode(base64_decode($payload));

            // Check if newlines are present
            $hasNewlines = strpos($decoded, "\n") !== false || strpos($decoded, "\r") !== false;

            // We expect NO newlines and the decoded content should match
            return ! $hasNewlines && $decoded === $signedXmlWithoutNewlines;
        }))
        ->willReturn($responseDto);

    $result = $service->emitir($dpsData);

    expect($result)->toBeInstanceOf(\Nfse\Dto\Nfse\NfseData::class);
});
