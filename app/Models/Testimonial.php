<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'testimonials';

    public $fillable = [
        'name',
        'message',
        'image',
        'status',
        'rating',
        'user_id',
    ];

    public $casts = [
        'user_id' => 'integer',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
