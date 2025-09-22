<?php

namespace Luna\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RuntimeException;

abstract class Module
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
     * The model the module corresponds to.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    public static string $model;

    /**
     * The pagination resource the module corresponds to.
     *
     * @var class-string<\Illuminate\Http\Resources\Json\ResourceCollection>
     */
    public static string $paginationResource;

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static bool $displayInNavigation = false;

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array<int, string>
     */
    public static array $with;

    /**
     * Get the columns displayed by the module.
     *
     * @return array<int, \Luna\Fields\Field>
     */
    abstract public function columns(): array;

    /**
     * Get the searchable fields used on searching the module.
     *
     * @return array<int, \Luna\Fields\Field>
     */
    abstract public function searchables(): array;

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

    /**
     * Get a new instance of the model the module corresponds to.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function model(): Model
    {
        if (!static::$model) {
            throw new RuntimeException(static::class . '::$model is not defined. Set the fully qualified class name of the underlying Eloquent model.');
        }

        $instance = new static::$model;

        if (!$instance instanceof Model) {
            throw new RuntimeException(sprintf('%s::$model must reference a class that extends %s.', static::class, Model::class));
        }

        return $instance;
    }
}
