<?php

/**
 * Exemplo de uso dos Enums nativos do PHP 8.1+
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Nfse\Enums\TipoAmbiente;
use Nfse\Enums\EmitenteDPS;
use Nfse\Enums\ProcessoEmissao;

echo "=== Exemplos de Uso dos Enums Nativos ===\n\n";

// Exemplo 1: Usando enums diretamente
echo "1. Usando Enums Diretamente:\n";
$ambiente = TipoAmbiente::Homologacao;
echo "   Ambiente: {$ambiente->value} - {$ambiente->getDescription()}\n";
echo "   Label: {$ambiente->label()}\n\n";

// Exemplo 2: Criando enum a partir de string
echo "2. Criando Enum a partir de String:\n";
$emitente = EmitenteDPS::from('1');  // Lança exceção se inválido
echo "   Emitente: {$emitente->value} - {$emitente->getDescription()}\n\n";

// Exemplo 3: Tentando criar (retorna null se inválido)
echo "3. Tentando Criar (tryFrom):\n";
$processo = ProcessoEmissao::tryFrom('1');
if ($processo) {
    echo "   Processo: {$processo->value} - {$processo->getDescription()}\n";
}

$invalido = ProcessoEmissao::tryFrom('99');
echo "   Inválido: " . ($invalido === null ? 'null' : $invalido->value) . "\n\n";

// Exemplo 4: Listando todos os casos
echo "4. Listando Todos os Casos:\n";
echo "   Tipos de Ambiente:\n";
foreach (TipoAmbiente::cases() as $case) {
    echo "     - {$case->name}: {$case->value} ({$case->getDescription()})\n";
}
echo "\n";

echo "   Emitentes:\n";
foreach (EmitenteDPS::cases() as $case) {
    echo "     - {$case->name}: {$case->value} ({$case->getDescription()})\n";
}
echo "\n";

// Exemplo 5: Comparação de enums
echo "5. Comparação de Enums:\n";
$amb1 = TipoAmbiente::Producao;
$amb2 = TipoAmbiente::from('1');
$amb3 = TipoAmbiente::Homologacao;

echo "   Producao === from('1'): " . ($amb1 === $amb2 ? 'true' : 'false') . "\n";
echo "   Producao === Homologacao: " . ($amb1 === $amb3 ? 'true' : 'false') . "\n\n";

// Exemplo 6: Match expressions
echo "6. Match Expressions:\n";
$ambiente = TipoAmbiente::Producao;
$mensagem = match ($ambiente) {
    TipoAmbiente::Producao => 'Conectando ao ambiente de PRODUÇÃO',
    TipoAmbiente::Homologacao => 'Conectando ao ambiente de HOMOLOGAÇÃO',
};
echo "   {$mensagem}\n\n";

// Exemplo 7: Type hints
echo "7. Type Hints:\n";
function configurarAmbiente(TipoAmbiente $ambiente): string
{
    return "Configurado para: {$ambiente->getDescription()}";
}

echo "   " . configurarAmbiente(TipoAmbiente::Homologacao) . "\n\n";

// Exemplo 8: Serialização
echo "8. Serialização:\n";
$data = [
    'ambiente' => TipoAmbiente::Producao->value,
    'emitente' => EmitenteDPS::Prestador->value,
    'processo' => ProcessoEmissao::WebService->value,
];
echo "   JSON: " . json_encode($data, JSON_PRETTY_PRINT) . "\n\n";

// Exemplo 9: Desserialização
echo "9. Desserialização:\n";
$json = '{"ambiente":"2","emitente":"1","processo":"1"}';
$decoded = json_decode($json, true);

$ambienteFromJson = TipoAmbiente::from($decoded['ambiente']);
$emitenteFromJson = EmitenteDPS::from($decoded['emitente']);
$processoFromJson = ProcessoEmissao::from($decoded['processo']);

echo "   Ambiente: {$ambienteFromJson->getDescription()}\n";
echo "   Emitente: {$emitenteFromJson->getDescription()}\n";
echo "   Processo: {$processoFromJson->getDescription()}\n\n";

// Exemplo 10: Validação
echo "10. Validação:\n";
try {
    $invalido = TipoAmbiente::from('99');  // Lança ValueError
} catch (ValueError $e) {
    echo "   ✓ Erro capturado: Valor '99' não é válido para TipoAmbiente\n";
}

$tentativa = TipoAmbiente::tryFrom('99');  // Retorna null
echo "   ✓ tryFrom('99') retorna: " . ($tentativa === null ? 'null' : $tentativa->value) . "\n\n";

echo "=== Vantagens dos Enums Nativos ===\n";
echo "✓ Type safety nativo do PHP\n";
echo "✓ Autocomplete melhor nas IDEs\n";
echo "✓ Validação automática com from()/tryFrom()\n";
echo "✓ Métodos nativos: cases(), from(), tryFrom()\n";
echo "✓ Suporte a match expressions\n";
echo "✓ Serialização/desserialização fácil\n";
echo "✓ Comparação de identidade (===)\n";
