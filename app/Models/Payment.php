<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guards = [];
    protected $fillable = ['user_id','whatsapp','payment_method_id','unique_code','total'];

    public function method(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
