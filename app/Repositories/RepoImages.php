<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class RepoImages
{
    public function attach(Model $model, string $relation, array $images = [], $directory = null): void
    {
        if (! method_exists($model, $relation)) {
            throw new \Exception($model::class . " does not have a {$relation} relation");
        }

        if (!empty($images)) {
            foreach ($images as $image) {
                // $product->images()
                call_user_func([$model, $relation])->create([
                    'path' => [
                        'image' => $image,
                        'directory' => $directory
                    ]
                ]);
            }
        }
    }
}