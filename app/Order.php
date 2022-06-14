<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Order
 *
 * @property Carbon $created_at
 * @property int $id
 * @property Carbon $updated_at
 * @property mixed $order_items
 * @property mixed $user
 * @property array|null|string clientPhone
 * @property array|null|string shipping_address
 * @property string status
 * @property array|null|string clientName
 * @property double shipping_amount
 * @property array|null|string email
 * @property string notes
 * @property mixed order_no
 * @property int|null $user_id
 * @property-read Collection|OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @property mixed payment_type
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereClientName($value)
 * @method static Builder|Order whereClientPhone($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereNotes($value)
 * @method static Builder|Order whereOrderNo($value)
 * @method static Builder|Order whereShippingAddress($value)
 * @method static Builder|Order whereShippingAmount($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    public static $shippingCharge = 1000;
    const PENDING = 'Pending';
    const PROCESSING = 'Processing';
    const ON_WAY = 'On Way';
    const DELIVERED = 'Delivered';
    const CANCELLED = 'Cancelled';
    const PAID = 'Paid';

    protected $appends = ['amount_to_pay'];


    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTotalAmountToPay(): float
    {
        return $this->orderItems->sum('sub_total') + $this->shipping_amount;
    }

    public function getAmountToPayAttribute(): float
    {
        return $this->getTotalAmountToPay();
    }

    public static function getStatuses(): array
    {

        return [self::PENDING, self::PROCESSING, self::ON_WAY, self::DELIVERED, self::PAID, self::CANCELLED];
    }

    public function setOrderNo(string $prefix = 'ORD', $pad_string = '0', int $len = 8)
    {
        $orderNo = $prefix . str_pad($this->id, $len, $pad_string, STR_PAD_LEFT);
        $this->order_no = $orderNo;
        $this->update();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
