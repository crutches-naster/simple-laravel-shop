<?php

namespace App\Models;

use App\Services\Storages\FileStorageService;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Product extends Model implements Buyable
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

                $key = "products.thumbnail.{$this->attributes['thumbnail']}";

                if (Cache::has($key)) {
                    return Cache::get($key);
                }

                $link = Storage::disk('s3')->temporaryUrl($this->attributes['thumbnail'], now()->addMinutes(10));
                Cache::put($key, $link, 570);
                return $link;

//                if (!Storage::exists($this->attributes['thumbnail'])) {
//                    return $this->attributes['thumbnail'];
//                }
//
//                // public/images/.....png
//                return Storage::url($this->attributes['thumbnail']);
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

    public function hasDiscount()
    {
        return $this->discount > 0;
    }

    public function endPrice(): Attribute
    {
        return Attribute::get(function() {
            $price = $this->attributes['base_price'];
            $discount = $this->attributes['discount'] ?? 0;

            $endPrice =  $discount === 0
                ? $price
                : ($price - ($price * $discount / 100));

            return $endPrice <= 0 ? 1 : round($endPrice, 2);
        });
    }

    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    public function getBuyableDescription($options = null)
    {
        return $this->title;
    }

    public function getBuyablePrice($options = null)
    {
        return $this->endPrice;
    }

    public function getBuyableWeight($options = null)
    {
        return 0;
    }
}
