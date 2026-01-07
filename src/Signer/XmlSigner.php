<?php

namespace Nfse\Signer;

use DOMDocument;
use DOMElement;
use DOMNode;
use Exception;

class XmlSigner implements SignerInterface
{
    private const CANONICAL = [true, false, null, null];

    public function __construct(private Certificate $certificate) {}

    /**
     * Sign XML content
     *
     * @param  string  $content  XML content to sign
     * @param  string  $tagname  Tag name to sign (e.g., 'infDPS')
     * @param  string  $mark  Attribute name for ID (default: 'Id')
     * @param  int  $algorithm  OpenSSL algorithm (default: OPENSSL_ALGO_SHA1)
     * @param  array  $canonical  Canonicalization options [exclusive, withComments, xpath, nsPrefixes]
     * @param  string  $rootname  Root element name for validation (optional)
     * @param  array  $options  Additional options (reserved for future use)
     * @return string Signed XML content
     */
    public function sign(
        string $content,
        string $tagname,
        string $mark = 'Id',
        int $algorithm = OPENSSL_ALGO_SHA1,
        array $canonical = self::CANONICAL,
        string $rootname = '',
        array $options = []
    ): string {
        if (empty($content)) {
            throw new Exception('Conteúdo XML vazio.');
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($content);
        $dom->encoding = 'UTF-8';

        $root = $dom->documentElement;

        // Validate root element if specified
        if (! empty($rootname) && $root->nodeName !== $rootname) {
            throw new Exception("Elemento raiz esperado: {$rootname}, encontrado: {$root->nodeName}");
        }

        $node = $dom->getElementsByTagName($tagname)->item(0);

        if (empty($node)) {
            throw new Exception("Tag {$tagname} não encontrada para assinatura.");
        }

        $this->createSignature(
            $dom,
            $root,
            $node,
            $mark,
            $algorithm,
            $canonical
        );

        $signedXml = $dom->saveXML();
        
        // Remove quebras de linha que podem causar problemas em alguns municípios
        return str_replace(["\r", "\n"], '', $signedXml);
    }

    private function createSignature(
        DOMDocument $dom,
        DOMNode $root,
        DOMElement $node,
        string $mark,
        int $algorithm,
        array $canonical
    ): void {
        $nsDSIG = 'http://www.w3.org/2000/09/xmldsig#';
        $nsCannonMethod = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';
        $nsSignatureMethod = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
        $nsDigestMethod = 'http://www.w3.org/2000/09/xmldsig#sha1';
        $digestAlgorithm = 'sha1';

        if ($algorithm == OPENSSL_ALGO_SHA256) {
            $digestAlgorithm = 'sha256';
            $nsSignatureMethod = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
            $nsDigestMethod = 'http://www.w3.org/2001/04/xmlenc#sha256';
        }

        $nsTransformMethod1 = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature';
        $nsTransformMethod2 = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';

        // Get ID attribute using the specified mark
        $idSigned = $node->getAttribute($mark);
        if (empty($idSigned)) {
            throw new Exception("Tag a ser assinada deve possuir um atributo '{$mark}'.");
        }

        // Calculate Digest
        $digestValue = $this->makeDigest($node, $digestAlgorithm, $canonical);

        // Create Signature Node
        $signatureNode = $dom->createElementNS($nsDSIG, 'Signature');
        // Append to parent of the node being signed
        $node->parentNode->appendChild($signatureNode);

        $signedInfoNode = $dom->createElement('SignedInfo');
        $signatureNode->appendChild($signedInfoNode);

        // CanonicalizationMethod
        $canonicalNode = $dom->createElement('CanonicalizationMethod');
        $signedInfoNode->appendChild($canonicalNode);
        $canonicalNode->setAttribute('Algorithm', $nsCannonMethod);

        // SignatureMethod
        $signatureMethodNode = $dom->createElement('SignatureMethod');
        $signedInfoNode->appendChild($signatureMethodNode);
        $signatureMethodNode->setAttribute('Algorithm', $nsSignatureMethod);

        // Reference
        $referenceNode = $dom->createElement('Reference');
        $signedInfoNode->appendChild($referenceNode);
        $referenceNode->setAttribute('URI', "#$idSigned");

        // Transforms
        $transformsNode = $dom->createElement('Transforms');
        $referenceNode->appendChild($transformsNode);

        $transfNode1 = $dom->createElement('Transform');
        $transformsNode->appendChild($transfNode1);
        $transfNode1->setAttribute('Algorithm', $nsTransformMethod1);

        $transfNode2 = $dom->createElement('Transform');
        $transformsNode->appendChild($transfNode2);
        $transfNode2->setAttribute('Algorithm', $nsTransformMethod2);

        // DigestMethod
        $digestMethodNode = $dom->createElement('DigestMethod');
        $referenceNode->appendChild($digestMethodNode);
        $digestMethodNode->setAttribute('Algorithm', $nsDigestMethod);

        // DigestValue
        $digestValueNode = $dom->createElement('DigestValue');
        $digestValueNode->appendChild($dom->createTextNode($digestValue));
        $referenceNode->appendChild($digestValueNode);

        // Calculate Signature
        $c14n = $this->canonize($signedInfoNode, $canonical);
        $signature = $this->certificate->sign($c14n, $algorithm);
        $signatureValue = base64_encode($signature);

        // SignatureValue
        $signatureValueNode = $dom->createElement('SignatureValue');
        $signatureValueNode->appendChild($dom->createTextNode($signatureValue));
        $signatureNode->appendChild($signatureValueNode);

        // KeyInfo
        $keyInfoNode = $dom->createElement('KeyInfo');
        $signatureNode->appendChild($keyInfoNode);

        $x509DataNode = $dom->createElement('X509Data');
        $keyInfoNode->appendChild($x509DataNode);

        $pubKeyClean = $this->certificate->getCleanCertificate();
        $x509CertificateNode = $dom->createElement('X509Certificate');
        $x509CertificateNode->appendChild($dom->createTextNode($pubKeyClean));
        $x509DataNode->appendChild($x509CertificateNode);
    }

    private function makeDigest(DOMNode $node, string $algorithm, array $canonical): string
    {
        $c14n = $this->canonize($node, $canonical);
        $hashValue = hash($algorithm, $c14n, true);

        return base64_encode($hashValue);
    }

    private function canonize(DOMNode $node, array $canonical): string
    {
        return $node->C14N(
            $canonical[0] ?? true,
            $canonical[1] ?? false,
            $canonical[2] ?? null,
            $canonical[3] ?? null
        );
    }
}
