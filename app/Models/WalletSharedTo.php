<?php

// app/Models/WalletSharedTo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class WalletSharedTo extends Model
{
    use SoftDeletes;

    protected $table = 'wallet_shared_to';

    protected $fillable = [
        'wallet_id',
        'email',
        'reason',
    ];

    protected $dates = ['deleted_at'];

    // Relationship to Wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // Scope to only show records where the wallet belongs to the authenticated user
    public function scopeWithUserWallets($query)
    {
        return $query->whereHas('wallet', function ($query) {
            $query->where('id_owner', Auth::id());
        });
    }
}
