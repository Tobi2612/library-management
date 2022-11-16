<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    use HasFactory;
    protected $guarded = ['null'];

    public const CHILDREN = 'Children';
    public const YOUTH = 'Youth';
    public const ADULT = 'Adult';
    public const SENIOR = 'Senior';


    public const CHILDREN_EXCLUSIVE = 'Children Exclusive';
    public const YOUTH_EXCLUSIVE = 'Youth Exclusive';
    public const ADULT_EXCLUSIVE = 'Adult Exclusive';
    public const SENIOR_EXCLUSIVE = 'Senior Exclusive';
}
