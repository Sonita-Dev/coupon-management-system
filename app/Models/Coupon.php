<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'value',
        'description',
        'start_date',
        'end_date',
        'min_order_amount',
        'max_uses',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];


    protected static function booted(): void
    {
        static::deleting(function (Coupon $coupon): void {
            if ($coupon->isForceDeleting()) {
                return;
            }

            $suffix = '__d_' . $coupon->getKey() . '_' . now()->timestamp;
            $maxCodeLength = 50;
            $trimmedCode = Str::limit($coupon->code, $maxCodeLength - strlen($suffix), '');

            $coupon->forceFill([
                'code' => $trimmedCode . $suffix,
            ])->saveQuietly();
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query
            ->whereNotNull('end_date')
            ->where('end_date', '<', now()->toDateString());
    }

    public function isCurrentlyValid(float $cartTotal): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        if ($this->min_order_amount && $cartTotal < $this->min_order_amount) {
            return false;
        }

        if (! is_null($this->max_uses) && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $cartTotal): float
    {
        if ($this->type === 'percent') {
            $discount = $cartTotal * ($this->value / 100);
        } else {
            $discount = $this->value;
        }

        if ($discount > $cartTotal) {
            $discount = $cartTotal;
        }

        return round($discount, 2);
    }
}

