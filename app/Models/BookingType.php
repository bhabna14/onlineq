<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BookingType extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_type_name',
        'booking_price',
        'created_by'
    ];
    /**
     * Get all of the booking for the BookingType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'booking_type_id', 'booking_type_id');
    }

    /**
     * Get all of the bookingDetails for the BookingType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function bookingDetail(): HasManyThrough
    {
        return $this->hasManyThrough(
            BookingDetail::class,
            Booking::class,
            'booking_type_id',
            'booking_id',
            'booking_type_id',
            'booking_id'
        );
    }
}
