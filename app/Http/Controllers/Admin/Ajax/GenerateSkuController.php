<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Models\Image;
use Illuminate\Support\Str;

class GenerateSkuController
{
    public function __invoke()
    {
        try
        {
            return response()->json([
                //ToDo move prefix to env or settings
                'sku' => 'PR-' . Str::random(8)
            ]);
        }
        catch (\Exception $exception)
        {
            logs()->error($exception);
            return response(status: 422)->json(['message' => $exception->getMessage()]);
        }
    }
}
