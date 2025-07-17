<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    protected $fillable = ['name', 'section', 'max_students'];
    use HasFactory;



    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
