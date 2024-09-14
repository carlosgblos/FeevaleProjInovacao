<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MovementType extends Model
{
    use SoftDeletes;

    protected $table = 'movement_type';

    protected $fillable = [
        'description',
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($movementType) {
            $movementType->id_owner = Auth::id();
        });

        static::updating(function ($movementType) {
            $movementType->id_owner = Auth::id();
        });
    }

    public function scopeOwnedByUser($query)
    {
        return $query->where('id_owner', Auth::id());
    }
}
