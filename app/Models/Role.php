<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = ['null'];


    public const ADMIN = 'admin';
    public const AUTHOR = 'author';
    public const READER = 'reader';
}
