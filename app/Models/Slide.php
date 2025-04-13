<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slide extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'slides';

    public $fillable = [
        'title',
        'subtitle',
        'image',
        'description',
        'order'
    ];

    public $casts = [
        'order' => 'integer',
        'user_id' => 'integer',
    ];

    protected $dates = ['deleted_at'];
}
