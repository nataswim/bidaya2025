<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_type', 'amount_paid', 'currency',
        'stripe_payment_intent_id', 'status', 'admin_status',
        'processed_by', 'processed_at', 'admin_notes'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'amount_paid' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function getPlanNameAttribute(): string
    {
        return config("stripe.plans.{$this->plan_type}.name", $this->plan_type);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->amount_paid / 100, 2) . ' €';
    }
}