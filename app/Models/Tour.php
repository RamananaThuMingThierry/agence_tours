<?php

namespace App\Models;

use App\Models\TourImages;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'tours';

    public $fillable = [
        'title',
        'description',
        'slug',
        'price',
        'status'
    ];

    public $casts = [
        'price' => 'decimal:2',

    ];

    protected $dates = ['deleted_at'];

    public function images()
    {
        return $this->hasMany(TourImages::class);
    }

    public function reservation(){
        return $this->belongTo(Reservation::class);
    }
}
