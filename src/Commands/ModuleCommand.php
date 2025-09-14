<?php

/*
namespace Illuminate\Routing\Console;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\suggest;

#[AsCommand(name: 'make:controller')]
class ControllerMakeCommand extends GeneratorCommand
*/

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
        return $rootNamespace.'\Luna\Modules';
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
        $model = $this->option('model') ?? str_replace($this->getNamespace($name).'\\', '', $name);

        return $this
            ->replaceNamespace($stub, $name)
            ->replaceModel($stub, $model)
            ->replaceClass($stub, $name);
    }
}
