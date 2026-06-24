<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'doctor_id', 'service_type', 'transaction_date', 'amount', 'status'];
    protected $table = 'transaction';
    
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_transactions', 'transaction_id', 'service_id')->withPivot('qty')->withTimestamps();
    }
    public static function createFromCart($data)
{
    $transaction = new Transaction();

    $transaction->user_id = Auth::user()->id ?? 1;
    $transaction->amount = self::calculateTotal($data);

    // field wajib lainnya
    $transaction->doctor_id = 1;
    $transaction->service_type = 'Cart Checkout';
    $transaction->transaction_date = now();
    $transaction->status = 'pending';

    $transaction->save();

    return $transaction;
}
    public static function calculateTotal($data)
    {
        $total = 0;
        foreach ($data as $item) {
            $price = Service :: find($item['id'])->price;
            $total += $price * $item['quantity'];
        }
        return $total;
    }
}
