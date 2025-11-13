<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    protected $fillable = [
        'project_id',
        'antecedent',
        'consequent',
        'support',
        'confidence',
        'lift',
    ];

    protected $casts = [
        'antecedent' => 'array',
        'consequent' => 'array',
        'support' => 'float',
        'confidence' => 'float',
        'lift' => 'float',
    ];

    /**
     * Get the project that owns the rule.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
