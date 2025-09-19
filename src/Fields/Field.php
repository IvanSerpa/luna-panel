<?php

namespace Luna\Fields;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use InvalidArgumentException;

abstract class Field implements Arrayable, Jsonable
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
     * Create a new Field instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

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
     * Dynamically get attributes on the field.
     *
     * @param string $key The attribute key to retrieve.
     *
     * @return mixed The value of the attribute, or throws an exception if the attribute does not exist.
     */
    public function __get(string $key)
    {
        return $this->attributes[$key] ?? match ($key) {
            'type'  => $this->type,
            default => throw new InvalidArgumentException("Unknown field attribute [$key].")
        };
    }

    /**
     * Dynamically set attributes on the field.
     *
     * @param string $key   The attribute key to set.
     * @param mixed  $value The value to set for the attribute.
     *
     * @return void
     */
    public function __set(string $key, mixed $value)
    {
        if (in_array($key, ['type'], true)) {
            $this->$key = $value;
            return;
        }

        $this->attributes[$key] = $value;
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

    /**
     * Convert the Field instance to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'       => $this->type,
            'attributes' => $this->attributes,
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
