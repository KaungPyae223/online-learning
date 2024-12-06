<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['level'];
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory;

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
