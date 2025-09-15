<?php

namespace Luna\Fields;

use Closure;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;

abstract class Field
{
    use Conditionable;
    use Macroable;

    /**
     * Field type.
     */
    protected string $type;

    /**
     * An array containing all attributes available to the field.
     */
    protected array $attributes = [
        'value' => null,
    ];

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        $arguments = collect($parameters)->map(static fn($argument) => $argument instanceof Closure ? $argument() : $argument);

        if (method_exists($this, $method)) {
            return $this->$method(...$arguments);
        }

        return $this->set($method, ...$arguments);
    }

    /**
     * Create a new Field element.
     *
     * @param string $name The name of the field.
     *
     * @return \Luna\Fields\Field
     */
    public static function make(string $name): Field
    {
        return (new static)->name($name);
    }

    /**
     * Sets the 'value' attribute of the field.
     *
     * @param mixed $value The value to be set for the 'value' attribute.
     *
     * @return static Returns the current instance for method chaining.
     */
    public function value(mixed $value): Field
    {
        return $this->set('value', $value);
    }

    /**
     * Sets the value for the specified attribute of the field.
     *
     * @param string $key   The name of the attribute to set.
     * @param mixed  $value The value of the attribute.
     *
     * @return static Returns the current instance for method chaining.
     */
    public function set(string $key,  mixed $value = true): Field
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Gets the value for the specified attribute of the field.
     *
     * @param string $key     The name of the attribute to get.
     * @param mixed  $default The default value to return if the attribute is not set.
     *
     * @return mixed
     */
    public function get(string $key, mixed $default): mixed
    {
        return $this->attributes[$key] ?? $default;
    }
}
