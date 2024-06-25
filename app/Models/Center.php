<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use HasFactory, SoftDeletes;


    // Belongs to Relationship with User
    protected $guarded = [];
    

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function students(): HasMany 
    {
        return $this->hasMany(Student::class);
    }
}
