<?php

namespace Luna\Commands;

use Symfony\Component\Console\Input\InputOption;

class ModuleCommand extends GeneratorCommand
{
    protected $name = 'luna:module';

    protected $description = 'Create a new module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the module already exists'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the module applies to'],
            ['description', 'd', InputOption::VALUE_OPTIONAL, 'The description of the module'],
        ];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('module.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Luna\Modules';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $description = $this->option('description') ?? 'A description for the module';

        return $this
            ->replaceNamespace($stub, $name)
            ->replaceModel($stub, $this->getModelInput())
            ->replaceDescription($stub, $description)
            ->replaceClass($stub, $name);
    }
}
