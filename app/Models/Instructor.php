<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    /** @use HasFactory<\Database\Factories\InstructorFactory> */
    use HasFactory;


    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function course(){
        return $this->hasMany(Course::class,'instructor_id','id');
    }

}
