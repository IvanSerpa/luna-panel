<?php

namespace Luna\Commands;

use Illuminate\Console\GeneratorCommand as BaseGeneratorCommand;
use Illuminate\Support\Str;
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
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $name = trim($this->argument('name'));

        if (Str::endsWith($name, '.php')) {
            $name = Str::substr($name, 0, -4);
        }

        if (!Str::endsWith($name, $this->type)) {
            $name .= $this->type;
        }

        return $name;
    }

    /**
     * Get the desired model from the input.
     *
     * @return string
     */
    protected function getModelInput()
    {
        $model = trim($this->option('model') ?? '');

        if (empty($model)) {
            $model = Str::replaceLast($this->type, '', $this->getNameInput());
        }

        return $model;
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
