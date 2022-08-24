<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HomeSlide
 *
 * @property int $id
 * @property string|null $header
 * @property string|null $description
 * @property string $image
 * @property int $is_active
 * @property int $show_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereShowText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeSlide whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HomeSlide extends Model
{

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('storage/images/slides' . $this->image);
    }
}
