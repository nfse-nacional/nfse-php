<?php

if (! function_exists('app')) {
    function app($abstract = null)
    {
        static $container = [];

        if ($abstract === null) {
            return $container;
        }

        if (isset($container[$abstract])) {
            return $container[$abstract];
        }

        // Manual overrides for complex cases or interfaces
        if ($abstract === \Illuminate\Contracts\Validation\Factory::class || $abstract === 'validator') {
            if (isset($container[\Illuminate\Contracts\Validation\Factory::class])) {
                return $container[$abstract] = $container[\Illuminate\Contracts\Validation\Factory::class];
            }

            return $container[$abstract] = $container[\Illuminate\Contracts\Validation\Factory::class] = new \Illuminate\Validation\Factory(
                new \Illuminate\Translation\Translator(
                    new \Illuminate\Translation\ArrayLoader,
                    'en'
                )
            );
        }

        if (class_exists($abstract)) {
            $reflection = new ReflectionClass($abstract);
            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                return $container[$abstract] = new $abstract;
            }

            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter) {
                $type = $parameter->getType();
                if ($type instanceof ReflectionNamedType && ! $type->isBuiltin()) {
                    $dependencies[] = app($type->getName());
                } elseif ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    // Try to provide empty array for array parameters if they are not optional
                    if ($type instanceof ReflectionNamedType && $type->getName() === 'array') {
                        $dependencies[] = [];
                    } else {
                        $dependencies[] = null;
                    }
                }
            }

            return $container[$abstract] = $reflection->newInstanceArgs($dependencies);
        }

        return null;
    }
}

// Set facade application
\Illuminate\Support\Facades\Facade::setFacadeApplication(new class implements ArrayAccess
{
    public function make($abstract)
    {
        return app($abstract);
    }

    public function bound($abstract)
    {
        return isset(app()[$abstract]);
    }

    public function offsetExists($offset): bool
    {
        return isset(app()[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return app($offset);
    }

    public function offsetSet($offset, $value): void
    {
        app()[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset(app()[$offset]);
    }
});

if (! function_exists('config')) {
    function config($key = null, $default = null)
    {
        $config = [];

        if ($key === null) {
            return $config;
        }

        $parts = explode('.', $key);
        $current = $config;

        foreach ($parts as $part) {
            if (! isset($current[$part])) {
                return $default;
            }
            $current = $current[$part];
        }

        return $current;
    }
}

if (! function_exists('resolve')) {
    function resolve($abstract = null)
    {
        return app($abstract);
    }
}

if (! function_exists('validarContraSchema')) {
    /**
     * Valida um XML contra os esquemas oficiais publicados em references/schemas.
     *
     * O TSSerieDPS do pacote oficial usa uma expressão regular com lookahead, que não é
     * aceita pela gramática de expressões do XML Schema e impede o libxml de compilar o
     * esquema. A cópia usada aqui substitui apenas esse padrão.
     */
    function validarContraSchema(string $xml, string $schema): bool
    {
        $origem = __DIR__.'/../references/schemas';
        $destino = sys_get_temp_dir().'/nfse-php-schemas';

        if (! is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        foreach (glob($origem.'/*.xsd') as $arquivo) {
            $conteudo = str_replace('^(?!0{1,5}$)\d{1,5}$', '[0-9]{1,5}', file_get_contents($arquivo));
            file_put_contents($destino.'/'.basename($arquivo), $conteudo);
        }

        $dom = new DOMDocument;
        $dom->loadXML($xml);

        $anterior = libxml_use_internal_errors(true);
        $valido = $dom->schemaValidate($destino.'/'.$schema);

        if (! $valido) {
            foreach (libxml_get_errors() as $erro) {
                fwrite(STDERR, trim($erro->message).PHP_EOL);
            }
        }

        libxml_clear_errors();
        libxml_use_internal_errors($anterior);

        return $valido;
    }
}
