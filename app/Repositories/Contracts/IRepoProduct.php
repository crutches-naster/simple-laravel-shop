<?php

namespace App\Repositories\Contracts;

interface IRepoProduct
{
    public function getAll();
    public function getPaginated(int $count, string $order_by_column);
    public function getPaginatedWithCategories(int $count, string $order_by_column);
}
