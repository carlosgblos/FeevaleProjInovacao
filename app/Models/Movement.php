<?php

// app/Models/Movement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Movement extends Model
{
    use SoftDeletes;

    protected $table = 'movement';

    protected $fillable = [
        'description',
        'vlr',
        'transaction_at',
        'id_movement_type',
        'transaction_type',
        'id_wallet',
    ];

    protected $dates = ['transaction_at', 'deleted_at'];

    protected $casts = [
        'transaction_at' => 'date',  // Cast transaction_at as a datetime
    ];

    // Automatically assign id_creator when inserting
    public static function boot()
    {
        parent::boot();

        static::creating(function ($movement) {
            $movement->id_creator = Auth::id();
        });
    }

    // Scope to show movements for owned or shared wallets
    public function scopeAccessibleByUser($query)
    {
        return $query->whereHas('wallet', function ($q) {
            $q->where('id_owner', Auth::id())
                ->orWhereHas('sharedTo', function ($q) {
                    $q->where('email', 'ilike', Auth::user()->email);
                });
        });
    }

    // Relationship to wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'id_wallet');
    }

    // Relationship to movement type
    public function movementType()
    {
        return $this->belongsTo(MovementType::class, 'id_movement_type');
    }
}
