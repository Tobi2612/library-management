<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['null'];

    public function bookplan()
    {
        return $this->hasMany(BookPlan::class);
    }


    public function book_access_level()
    {
        return $this->hasMany(BookAccessLevel::class);
    }

    public function author()
    {
        return $this->hasMany(Author::class);
    }
}
