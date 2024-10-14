<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
        'dp',
        'ship_cost',
        'actor_id',
    ];

    function getSubtotalAttribute() {
        return $this->sale_products->sum('amount');
    }

    function getRemainAttribute() {
        return ($this->sale_products->sum('amount') - $this->dp) + $this->ship_cost;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function sale_products(){
        return $this->hasMany(SaleProduct::class, 'sale_id');
    }

}
