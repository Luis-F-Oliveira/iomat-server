<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesOnNavigations extends Model
{
    use HasFactory;

    protected $fillable = [
        'navigation_id',
        'role_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
