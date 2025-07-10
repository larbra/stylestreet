<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;    // В CartItem модели
class CartItem extends Model
{
    protected $fillable = ['user_id', 'tovar_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tovar()
    {
        return $this->belongsTo(Tovar::class);
    }
}
