<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dataset extends Model
{
    protected $fillable = [
        'project_id',
        'file_name',
        'storage_path',
        'row_count',
        'imported_at',
    ];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

    /**
     * Get the project that owns the dataset.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
