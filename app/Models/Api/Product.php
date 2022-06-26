<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','description','cost','amount_available','seller_id'];

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
   
}
