<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use VanOns\Laraberg\Traits\RendersContent;

class Lesson extends Model
{
    use RendersContent;

    protected $fillable = ['title', 'content', 'course_id', 'status', 'image'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

}
