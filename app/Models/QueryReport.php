<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'dni',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];



    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
