<?php
// app/Models/Wallet.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Wallet extends Model
{
    use SoftDeletes;

    protected $table = 'wallet';

    protected $fillable = [
        'description',
        'id_currency',
    ];

    protected $dates = ['deleted_at'];

    // Automatically assign id_owner when inserting or updating
    public static function boot()
    {
        parent::boot();

        static::creating(function ($wallet) {
            $wallet->id_owner = Auth::id();
        });

        static::updating(function ($wallet) {
            $wallet->id_owner = Auth::id();
        });
    }

    // Scope to show wallets owned by the authenticated user or shared with their email
    public function scopeAccessibleByUser($query)
    {
        return $query->where('id_owner', Auth::id())
            ->orWhereHas('sharedTo', function ($q) {
                $q->where('email', Auth::user()->email); // Assuming you have an email field on the user model
            });
    }

    // Relationship to WalletSharedTo
    public function sharedTo()
    {
        return $this->hasMany(WalletSharedTo::class, 'wallet_id');
    }

    // Relationship to Currency
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'id_currency');
    }
}

