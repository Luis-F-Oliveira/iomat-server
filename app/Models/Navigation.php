<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'href',
        'route',
        'parent_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(Navigation::class, 'parent_id')
            ->with('replies');
    }

    public function parent()
    {
        return $this->belongsTo(Navigation::class, 'parent_id');
    }
}
