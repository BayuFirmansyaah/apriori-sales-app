<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'project_id',
        'transaction_id',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    /**
     * Get the project that owns the transaction.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
