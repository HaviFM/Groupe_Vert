<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormModel extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'tel',
        'password',

    ];

}
