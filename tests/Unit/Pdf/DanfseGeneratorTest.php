<?php

namespace Nfse\Tests\Unit\Pdf;

use Nfse\Pdf\DanfseGenerator;
use PHPUnit\Framework\TestCase;

class DanfseGeneratorTest extends TestCase
{
    public function test_generates_single_page_pdf_from_authorized_xml(): void
    {
        $xml = file_get_contents(__DIR__.'/../../fixtures/nfse.xml');
        $pdf = (new DanfseGenerator)->generate($xml);

        self::assertStringStartsWith('%PDF-', $pdf);
        self::assertStringContainsString('/Count 1', $pdf);
        self::assertGreaterThan(10_000, strlen($pdf));
    }

    public function test_rejects_xml_without_50_digit_access_key(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('50 dígitos');

        (new DanfseGenerator)->generate('<NFSe><infNFSe Id="NFS123"/></NFSe>');
    }
}
