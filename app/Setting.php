<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Setting
 *
 * @property string logo
 * @property string address
 * @property string email2
 * @property string email1
 * @property string phoneNumber3
 * @property string phoneNumber2
 * @property string phoneNumber1
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property string company_name
 * @property string whatsapp
 * @method static orderBy(string $string, string $string1)
 * @property string $about
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereEmail1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereEmail2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting wherePhoneNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting wherePhoneNumber2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereWhatsapp($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::saving(function () {
            Cache::forget('defaultSetting');
        });
    }
}
