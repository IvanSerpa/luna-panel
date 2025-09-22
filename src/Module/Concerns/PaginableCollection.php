<?php

namespace Luna\Module\Concerns;

trait PaginableCollection
{
    /**
     * The module the collection corresponds to.
     *
     * @var class-string<\Luna\Module\Module>
     */
    public static string $module;

    public static function getModule(): string
    {
        if (isset(static::$module)) {
            return static::$module;
        }

        $moduleClass = str_replace('Collection', 'Module', class_basename(static::class));

        return "App\\Luna\\Modules\\$moduleClass";
    }

    /**
     * Customize the pagination information for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array $paginated
     * @param  array $default
     *
     * @return array
     */
    public function paginationInformation($request, $paginated, $default)
    {
        $module = static::getModule();
        $default['meta']['per_page_options'] = $module::$perPageOptions ?? [20];

        return $default;
    }
}
