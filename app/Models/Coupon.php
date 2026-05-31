<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'minimum_order_value',
        'maximum_discount',
        'start_date',
        'expiry_date',
        'usage_limit',
        'usage_limit_per_user',
        'times_used',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_order_value' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'start_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid($orderTotal = 0, $userId = null): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'This coupon is no longer active.'];
        }

        if ($this->start_date && Carbon::today()->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'This coupon is not yet active.'];
        }

        if ($this->expiry_date && Carbon::today()->gt($this->expiry_date)) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }

        if ($this->usage_limit && $this->times_used >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        if ($userId && $this->usage_limit_per_user) {
            $userUsageCount = $this->usages()->where('user_id', $userId)->count();
            if ($userUsageCount >= $this->usage_limit_per_user) {
                return ['valid' => false, 'message' => 'You have already used this coupon.'];
            }
        }

        if ($orderTotal > 0 && $orderTotal < $this->minimum_order_value) {
            return ['valid' => false, 'message' => "Minimum order value of ₹" . number_format($this->minimum_order_value, 0) . " required."];
        }

        return ['valid' => true, 'message' => 'Coupon applied successfully!'];
    }

    public function calculateDiscount($orderTotal): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($this->discount_value / 100) * $orderTotal;
        } else {
            $discount = $this->discount_value;
        }

        if ($this->maximum_discount && $discount > $this->maximum_discount) {
            $discount = $this->maximum_discount;
        }

        // Never discount more than the order total
        return min($discount, $orderTotal);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
