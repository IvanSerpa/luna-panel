<?php

namespace Luna\Fields;

class ID extends Field
{
    /**
     * Field type.
     */
    public string $type = 'id';

    /**
     * Create a new ID element.
     *
     * @param string $name The name of the field.
     *
     * @return \Luna\Fields\Field
     */
    public static function make(string $name = 'id'): Field
    {
        return (new static)->name($name)->label('ID');
    }
}
