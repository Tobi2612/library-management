<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPlan extends Model
{
    use HasFactory;
    protected $guarded = ['null'];


    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
