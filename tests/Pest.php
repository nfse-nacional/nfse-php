<?php

if (!function_exists('app')) {
    function app($abstract = null) {
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
                    new \Illuminate\Translation\ArrayLoader(),
                    'en'
                )
            );
        }

        if ($abstract === \Spatie\LaravelData\Support\DataConfig::class) {
            return $container[$abstract] = new \Spatie\LaravelData\Support\DataConfig();
        }

        if (class_exists($abstract)) {
            $reflection = new ReflectionClass($abstract);
            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                return $container[$abstract] = new $abstract();
            }

            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter) {
                $type = $parameter->getType();
                if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
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
\Illuminate\Support\Facades\Facade::setFacadeApplication(new class implements ArrayAccess {
    public function make($abstract) { return app($abstract); }
    public function bound($abstract) { return isset(app()[$abstract]); }
    public function offsetExists($offset): bool { return isset(app()[$offset]); }
    public function offsetGet($offset): mixed { return app($offset); }
    public function offsetSet($offset, $value): void { app()[$offset] = $value; }
    public function offsetUnset($offset): void { unset(app()[$offset]); }
});

if (!function_exists('config')) {
    function config($key = null, $default = null) {
        $config = [
            'data' => [
                'date_format' => 'Y-m-d\TH:i:sP',
                'transformers' => [],
                'casts' => [],
                'mappers' => [],
                'rules' => [],
                'normalizers' => [
                    \Spatie\LaravelData\Normalizers\ArrayNormalizer::class,
                    \Spatie\LaravelData\Normalizers\ObjectNormalizer::class,
                ],
                'validation_strategy' => 'always',
            ],
        ];

        if ($key === null) return $config;

        $parts = explode('.', $key);
        $current = $config;

        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                return $default;
            }
            $current = $current[$part];
        }

        return $current;
    }
}

if (!function_exists('resolve')) {
    function resolve($abstract = null) {
        return app($abstract);
    }
}
