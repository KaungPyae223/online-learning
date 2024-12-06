<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    /** @use HasFactory<\Database\Factories\CurriculumFactory> */
    use HasFactory;

    public function lesson () {
        return $this->hasMany(Lesson::class,'curriculum_id','id');
    }
}
