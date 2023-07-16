<?php

namespace App\Repositories\Contracts;

interface IRepoCategory extends IRepoBase
{
    public function getPaginated(int $count, string $order_by_column);
    public function createNew(string $name, string $slug, string $description, int $parent_category_id );
    public function update(int $id, string $name, string $slug, string $description, int $parent_category_id );
}
