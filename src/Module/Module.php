<?php

namespace Luna\Module;

use Illuminate\Support\Str;

class Module
{
    /**
     * The name of the module.
     *
     * @var string
     */
    public static string $name;

    /**
     * The description of the module.
     *
     * @var string
     */
    public static string $description;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string
     */
    public static string $model;

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static bool $displayInNavigation = false;

    /**
     * Get the slug for the module, derived from the name.
     *
     * @return string
     */
    public static function slug(): string
    {
        $name = static::$name ?? class_basename(static::class);
        $name = Str::kebab($name);

        return Str::slug($name);
    }
}
