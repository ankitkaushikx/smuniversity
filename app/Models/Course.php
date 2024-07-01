<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function program() : BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function students() : HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'course_subject')
            ->withPivot('year', 'semester');
    }

    public function activeSubjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'course_subject')
                    ->withPivot('year', 'semester')
                    ->where('subjects.status', 'active');
    }

}
