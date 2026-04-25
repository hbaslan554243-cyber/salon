<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'amount_paid',
        'payment_method',
        'status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at'     => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
