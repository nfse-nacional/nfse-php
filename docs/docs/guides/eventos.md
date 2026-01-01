---
title: Eventos (Cancelamento)
sidebar_position: 3
---

Exemplo de criação e envio de evento (cancelamento).

```php
use Nfse\Signer\Certificate;
use Nfse\Signer\XmlSigner;

// Exemplo: montar o XML do pedido de registro de evento (simplificado)
$pedidoXml = "<PedidoRegistroEvento>...seu-xml-de-evento-aqui...</PedidoRegistroEvento>";

// Assinatura (exemplo simplificado — adapte conforme schema do evento)
$cert = new Certificate('/path/to/cert.pfx', 'password');
$signer = new XmlSigner($cert);
$signedXml = $signer->sign($pedidoXml, 'PedidoRegistroEvento');

// Compactar (gzip) e codificar em base64
$payload = base64_encode(gzencode($signedXml));

// Registrar evento na NFS-e (note a assinatura do método)
$resultado = $service->registrarEvento('12345678901234567890123456789012345678901234567890', $payload);
if ($resultado->sucesso) {
    echo "Evento registrado com sucesso!";
}
```
