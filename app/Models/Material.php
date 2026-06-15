<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $fillable = [
        'question_topic_id',
        'title',
        'description',
        'file_path',
        'original_name',
        'file_size',
        'download_count',
        'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'file_size'      => 'integer',
        'download_count' => 'integer',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(QuestionTopic::class, 'question_topic_id');
    }

    public function getReadableSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        return number_format($bytes / 1024, 0) . ' KB';
    }
}