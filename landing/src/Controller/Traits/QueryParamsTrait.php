<?php

namespace App\Controller\Traits;

trait QueryParamsTrait
{
    public int $defaultPage = 1;
    public int $defaultPerPage = 10;

    public function getPerPageParam(): int
    {
        $perPage = $this->request->query->getInt('per_page', $this->defaultPerPage);

        return ($perPage > 0) ? $perPage : $this->defaultPage;
    }

    public function getPageParam(): int
    {
        $page = $this->request->query->getInt('page', $this->defaultPage);

        return ($page > 0) ? $page : $this->defaultPage;
    }
}
