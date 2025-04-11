<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourImages extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'tour_images';
    
    public $fillable = [
        'image',
        'tour_id',
    ];

    public $casts = [
        'image' => 'string',
        'tour_id' => 'integer',
    ];
    
    protected $dates = ['deleted_at'];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}
