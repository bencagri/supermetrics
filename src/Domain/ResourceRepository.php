<?php

namespace SuperMetrics\Domain;

interface ResourceRepository
{
    const MAX_PAGE = 10;
    /**
     * @param int $page
     * @return mixed
     */
    public function getPosts($page = 1);
}
