---
title: Consultar NFS-e
sidebar_position: 2
---

Guia rápido para consultar uma NFS-e por chave de acesso.

```php
$chave = '12345678901234567890123456789012345678901234567890';
$nfse = $service->consultar($chave);
if ($nfse) {
    echo "Nota encontrada! Emitida em: " . $nfse->infNfse->dataEmissao;
} else {
    echo "Nota não encontrada.";
}
```
