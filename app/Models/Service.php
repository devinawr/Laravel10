<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $fillable = ['service_name', 'description', 'availability', 'price', 'category_id'];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function show(Service $service)
    {
        return view ('services.show', compact('service'));
    }
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class) ->withPivot('qty')->withTimestamps();
    }
}
