<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'galleries';

    public $fillable = [
        'image_url',
        'status'
    ];

    public $casts = [
        'image_url' => 'string',
    ];

    protected $dates = ['deleted_at'];
}
