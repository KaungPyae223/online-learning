<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'language',
    ];
    /** @use HasFactory<\Database\Factories\LanguageFactory> */
    use HasFactory;

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
