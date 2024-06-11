<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'booking_date',
        'booking_type_id',
        'is_cancelled',
        'cancel_reason',
        'created_by'
    ];
    public function bookingType()
    {
        return $this->hasOne(BookingType::class, 'booking_type_id', 'booking_type_id');
    }
}
