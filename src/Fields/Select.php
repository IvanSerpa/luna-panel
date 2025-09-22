<?php

namespace Luna\Fields;

class Select extends Field
{
    /**
     * Field type.
     */
    public string $type = 'select';

    /**
     * Create a new Select element.
     *
     * @param string $name The name of the field.
     *
     * @return \Luna\Fields\Field
     */
    public static function make(string $name = 'select'): Field
    {
        return (new static)->name($name)->label('');
    }
}
