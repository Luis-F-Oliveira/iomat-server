<?php

namespace App\Models;

use App\Models\Servant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CollectedData extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'url',
        'servant_id'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function servant()
    {
        return $this->belongsTo(Servant::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
