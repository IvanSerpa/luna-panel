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

use Luna\Commands\GeneratorCommand;

class ModuleCommand extends GeneratorCommand
{
    protected $name = 'luna:module';

    protected $description = 'Create a new module';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'luna:module {name} {model?}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

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
     * @param string $rootNamespace
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
        $stub  = $this->files->get($this->getStub());
        $model = $this->argument('model') ?? str_replace($this->getNamespace($name) . '\\', '', $name);;

        return $this
            ->replaceNamespace($stub, $name)
            ->replaceModel($stub, $model)
            ->replaceClass($stub, $name);
    }
}
