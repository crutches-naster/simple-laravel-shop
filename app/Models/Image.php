<?php

namespace App\Models;

use App\Services\Storages\FileStorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'imageable_id', 'imageable_type'];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function setPathAttribute(array $path)
    {
        $this->attributes['path'] = FileStorageService::upload(
            $path['image'],
            $path['directory'] ?? null
        );
    }

    public function url(): Attribute
    {
//        return Attribute::make(
//            get: function() {
//                if ( !Storage::exists($this->attributes['path'])) {
//                    return $this->attributes['path'];
//                }
//
//                // public/images/.....png
//                return Storage::url($this->attributes['path']);
//            }
//        );

        return Attribute::make(
            get: function() {
                $key = "products.images.{$this->attributes['path']}";

                if ( Cache::has($key) ) {
                    return Cache::get($key);
                }

                $link = Storage::disk('s3')
                    ->temporaryUrl($this->attributes['path'], now()->addMinutes(10));

                Cache::put($key, $link, 570);
                return $link;
            }
        );
    }
}
