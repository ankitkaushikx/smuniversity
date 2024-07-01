<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Course;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Subject extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];



     public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_subject')
            ->withPivot('year', 'semester');
                   
    }
}
