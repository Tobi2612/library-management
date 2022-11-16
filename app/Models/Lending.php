<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;
    protected $guarded = ['null'];

    protected $dates = ['date_time_borrowed', 'date_time_due', 'date_time_returned'];
}
