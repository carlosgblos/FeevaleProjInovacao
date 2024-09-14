<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Movement;

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

    public function movements()
    {
        return $this->hasMany(Movement::class, 'id_movement_type');
    }

    /**
     * Scope a query to only include movement types accessible by the authenticated user.
     */
    public function scopeAccessibleByUser($query)
    {
        $userId = Auth::id();

        // Subquery for wallets the user owns or has access to
        $accessibleWallets = Wallet::where('id_owner', $userId)
            ->orWhereHas('sharedTo', function ($q) use ($userId) {
                $q->where('email', Auth::user()->email);
            });

        // Filter movement types either owned by the user or used in movements accessible to the user
        return $query->where('id_owner', $userId)
            ->orWhereHas('movements', function ($q) use ($accessibleWallets) {
                $q->whereIn('id_wallet', $accessibleWallets->pluck('id'));
            });
    }

}
