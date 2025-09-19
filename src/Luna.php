<?php

namespace Luna;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Luna\Module\Module as BaseModule;
use ReflectionClass;

class Luna
{
    /**
     * Return the configured module class names that exist & extend BaseModule.
     */
    public function modules(): Collection
    {
        $baseNamespace    = app()->getNamespace();
        $modulesNamespace = trim($baseNamespace, '\\') . '\\Luna\\Modules';
        $found            = collect();
        $paths            = [
            app_path('Luna/Modules'),
        ];

        foreach ($paths as $path) {
            if (!is_dir($path)) {
                continue;
            }

            foreach (glob($path . '/*.php') as $file) {
                $classBase = pathinfo($file, PATHINFO_FILENAME);
                $class = $modulesNamespace . '\\' . $classBase;
                if (!class_exists($class)) {
                    // Attempt to require the file (in case composer hasn't loaded it - dev context)
                    require_once $file;
                }

                if (class_exists($class) && is_subclass_of($class, BaseModule::class)) {
                    // Filter abstract classes
                    $ref = new ReflectionClass($class);
                    if (!$ref->isAbstract()) {
                        $found->push($class);
                    }
                }
            }
        }

        // Unique & sorted by readable name
        return $found->unique()->sortBy(fn($class) => Str::lower(class_basename($class)))->values();
    }
}
