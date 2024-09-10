<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'stripe_payment_id',
        'method',
        'currency',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function makePayment(User $user, float $amount, string $payment_id, string $description = "", string $method = 'stripe')
    {
        $this->user_id = $user->id;
        $this->amount = $amount;
        $this->stripe_payment_id = $payment_id;
        $this->method = $method;
        $this->description = $description;
        $this->currency = 'pln';
        $this->status = 'unpaid';
        $this->save();
    }

    public function checkStatus()
    {
        return $this->status;
    }
}
