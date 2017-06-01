<?php

namespace Analogue\ORM;

use Illuminate\Pagination\LengthAwarePaginator;

class LengthAwareEntityPaginator extends LengthAwarePaginator
{
    /**
     * Paginator constructor.
     *
     * @param mixed $items
     * @param int $perPage
     * @param null $currentPage
     * @param array $options
     */
    public function __construct($items, $perPage, $currentPage = null, array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->{$key} = $value;
        }

        $this->perPage = $perPage;
        $this->currentPage = $this->setCurrentPage($currentPage);
        $this->path = $this->path != '/' ? rtrim($this->path, '/') : $this->path;
        $this->items = $items instanceof EntityCollection ? $items : EntityCollection::make($items);

        $this->checkForMorePages();
    }
}
