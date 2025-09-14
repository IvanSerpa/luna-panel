<?php

namespace Luna\Commands;

use Illuminate\Console\GeneratorCommand as BaseGeneratorCommand;
use Luna\Configuration\Package;

abstract class GeneratorCommand extends BaseGeneratorCommand
{
    /**
     * Resolve the fully-qualified path to the stub.
     */
    protected function resolveStubPath(string $stub): string
    {
        $path = $this->laravel->basePath('stubs' . DIRECTORY_SEPARATOR . 'luna' . DIRECTORY_SEPARATOR . trim($stub, DIRECTORY_SEPARATOR));

        return file_exists($path)
            ? $path
            : Package::path('stubs' . DIRECTORY_SEPARATOR . $stub);
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return $this
     */
    protected function replaceModel(&$stub, $model)
    {
        $stub = str_replace(['DummyModel', '{{ model }}', '{{model}}'], $model, $stub);

        return $this;
    }

    /**
     * Replace the description for the given stub.
     *
     * @param  string  $stub
     * @param  string  $description
     * @return $this
     */
    protected function replaceDescription(&$stub, $description)
    {
        $stub = str_replace(['DummyDescription', '{{ description }}', '{{description}}'], $description, $stub);

        return $this;
    }
}
