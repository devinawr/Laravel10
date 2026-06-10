<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'doctor_id', 'service_type', 'transaction_date', 'amount', 'status'];
    protected $table = 'transaction';
    
    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('qty')->withTimestamps();
    }
}
