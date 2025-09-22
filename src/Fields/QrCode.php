<?php

namespace Luna\Fields;

class QrCode extends Field
{
    /**
     * Field type.
     */
    public string $type = 'qr_code';

    /**
     * Create a new QR code element.
     *
     * @param string $name The name of the field.
     *
     * @return \Luna\Fields\Field
     */
    public static function make(string $name = 'qr_code'): Field
    {
        return (new static)->name($name)->label('QR Code & Form');
    }
}
