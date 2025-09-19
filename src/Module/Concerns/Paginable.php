<?php

namespace Luna\Module\Concerns;

trait Paginable
{
    /**
     * The pagination per-page options used the resource index.
     */
    public static array $perPageOptions = [20, 50, 100, 150];

    /**
     * Pagination type. ['links', 'simple', 'infinite']
     */
    public static string $paginationType = 'links';
}
