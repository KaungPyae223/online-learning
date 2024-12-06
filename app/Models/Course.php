<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    public function category () {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function language () {
        return $this->belongsTo(Language::class,'language_id','id');
    }

    public function level () {
        return $this->belongsTo(Level::class,'level_id','id');
    }

    public function instructor () {
        return $this->belongsTo(Instructor::class,'instructor_id','id');
    }

    public function curriculum () {
        return $this->hasMany(Curriculum::class,'course_id','id');
    }

    public function review() {
        return $this->hasMany(Review::class,"course_id","id");
    }

    public function user() {
        return $this->belongsToMany(User::class,'course_students','course_id','user_id','id','id');
    }

    public function faq() {
        return $this->hasMany(FAQ::class,"course_id","id");
    }

}
