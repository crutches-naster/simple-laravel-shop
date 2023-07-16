<?php

namespace App\Repositories\Contracts;

interface IRepoBase
{
    public function getAll();
    public function getById(int $id);
    public function destroy(int $id);
}
