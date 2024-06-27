<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servant extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment',
        'contract',
        'name',
        'email'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
