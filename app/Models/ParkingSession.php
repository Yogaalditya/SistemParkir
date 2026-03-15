<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'public_token',
        'checked_in_at',
        'paid_at',
        'payment_method',
        'payment_status',
        'base_fee',
        'checked_out_at',
        'admin_confirmed_by',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'paid_at' => 'datetime',
            'checked_out_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function adminConfirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_confirmed_by');
    }

    public function currentFee(): int
    {
        $endTime = $this->checked_out_at ?? now();
        $threshold = Carbon::parse($this->checked_in_at->format('Y-m-d').' 16:30:00');
        $startBillingAt = $this->checked_in_at->greaterThan($threshold) ? $this->checked_in_at : $threshold;

        if ($endTime->lessThanOrEqualTo($startBillingAt)) {
            return (int) $this->base_fee;
        }

        $minutes = $startBillingAt->diffInMinutes($endTime);
        $extraUnits = (int) ceil($minutes / 60);

        return (int) $this->base_fee + ($extraUnits * 1000);
    }

    public function parkingDurationMinutes(): int
    {
        $endTime = $this->checked_out_at ?? now();

        return $this->checked_in_at->diffInMinutes($endTime);
    }

    public function isPaymentConfirmed(): bool
    {
        return $this->payment_status === 'paid';
    }
}
