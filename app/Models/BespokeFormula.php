<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BespokeFormula extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'vessel',
        'wick',
        'top',
        'heart',
        'base',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
