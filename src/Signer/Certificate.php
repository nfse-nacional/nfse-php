<?php

namespace Nfse\Signer;

use Exception;

class Certificate
{
    private string $pfxContent;

    private string $password;

    private ?array $certData = null;

    public function __construct(string $pfxPath, string $password)
    {
        if (! file_exists($pfxPath)) {
            throw new Exception("Certificado não encontrado: {$pfxPath}");
        }

        $this->pfxContent = file_get_contents($pfxPath);
        $this->password = $password;
        $this->load();
    }

    public static function fromContent(string $pfxContent, string $password): self
    {
        $instance = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
        $instance->pfxContent = $pfxContent;
        $instance->password = $password;
        $instance->load();

        return $instance;
    }

    private function load(): void
    {
        if (! openssl_pkcs12_read($this->pfxContent, $certs, $this->password)) {
            // Capture OpenSSL error
            $sslError = '';
            while ($msg = openssl_error_string()) {
                $sslError .= $msg.'; ';
            }

            if (str_contains($sslError, 'ee key too small') || str_contains($sslError, 'CA key too small')) {
                throw new Exception("O certificado digital possui uma chave muito fraca (menor que 2048 bits) e foi rejeitado pelas políticas de segurança do servidor. Por favor, utilize um certificado mais seguro (A1 ou A3 atualizado). Detalhes: {$sslError}");
            }

            throw new Exception("Senha do certificado incorreta ou arquivo inválido/corrompido. Detalhes OpenSSL: {$sslError}");
        }

        // Check expiration
        if (isset($certs['cert'])) {
            $certDetails = openssl_x509_parse($certs['cert']);
            if ($certDetails && isset($certDetails['validTo_time_t'])) {
                if (time() > $certDetails['validTo_time_t']) {
                    $validTo = date('d/m/Y H:i:s', $certDetails['validTo_time_t']);
                    throw new Exception("O certificado digital está vencido. Data de validade: {$validTo}. Por favor, utilize um certificado válido.");
                }
            }
        }

        $this->certData = $certs;
    }

    public function getPrivateKey(): string
    {
        return $this->certData['pkey'];
    }

    public function getCertificate(): string
    {
        return $this->certData['cert'];
    }

    public function getCleanCertificate(): string
    {
        $cert = $this->getCertificate();
        $cert = str_replace('-----BEGIN CERTIFICATE-----', '', $cert);
        $cert = str_replace('-----END CERTIFICATE-----', '', $cert);

        return str_replace(["\r", "\n"], '', $cert);
    }

    public function sign(string $content, int $algorithm = OPENSSL_ALGO_SHA1): string
    {
        $signature = '';
        if (! openssl_sign($content, $signature, $this->getPrivateKey(), $algorithm)) {
            throw new Exception('Falha ao assinar o conteúdo: '.openssl_error_string());
        }

        return $signature;
    }
}
