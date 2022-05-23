<?php

namespace App\Filters;

abstract class Filters
{
    protected $query;

    protected $filters = [];

    public function apply($query)
    {
        $this->query = $query;

        foreach (request()->only($this->filters) as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
    }
}
