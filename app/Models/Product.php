<?php

namespace App\Models;

use App\Services\Storages\FileStorageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'sku',
        'base_price',
        'discount',
        'quantity',
        'thumbnail_url',
        'thumbnail',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }


    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function() {

                if($this->attributes['thumbnail'] == null){
                    return 'https://via.placeholder.com/640x480.png/004466?text=no thumbnail';
                }

                if (!Storage::exists($this->attributes['thumbnail'])) {
                    return $this->attributes['thumbnail'];
                }

                // public/images/.....png
                return Storage::url($this->attributes['thumbnail']);
            }
        );

    }

    public function setThumbnailAttribute($image)
    {
        if (!empty($this->attributes['thumbnail'])) {
            FileStorageService::remove($this->attributes['thumbnail']);
        }

        //dd($this->attributes);

        $this->attributes['thumbnail'] = FileStorageService::upload(
            $image,
            $this->attributes['slug'] ?? Str::of($this->attributes['title'])->slug('-')
        );
    }
}
