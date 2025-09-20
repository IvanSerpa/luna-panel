<?php

namespace Luna\Utils;

class InertiaRender
{
    /**
     * Render a response using the Inertia response factory.
     *
     * @param  string $component
     * @param  array  $props
     * @return \Inertia\Response
     */
    public static function render(string $component, array $props = [])
    {
        $factory = app('Inertia\ResponseFactory');

        return $factory->render($component, $props);
    }
}
