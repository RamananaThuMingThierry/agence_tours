<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'reservations';

    public $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'tour_id',
        'status',
    ];

    public $casts = [
        'tour_id' => 'integer',
        'user_id' => 'integer',
    ];

    protected $dates = ['deleted_at'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
