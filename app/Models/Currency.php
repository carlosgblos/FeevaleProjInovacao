<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    protected $table = 'currency';

    protected $fillable = [
        'description',
        'abbreviation',
    ];

    protected $dates = ['deleted_at']; // For soft deletes
}
