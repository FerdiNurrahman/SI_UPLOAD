<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    // Field yang bisa diisi secara massal
    protected $fillable = ['name', 'account_id'];

    // Relasi ke model Account
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
