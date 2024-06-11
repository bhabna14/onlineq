<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class BookingDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_detail_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'full_name',
        'age',
        'gender',
        'relation_id',
        'id_proof_type_id',
        'id_number',
        'disable_certificate',
        'phone',
        'full_image',
        'is_attendant',
        'created_by'
    ];

    /**
     * Get the booking associated with the BookingDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function idProof()
    {
        return $this->hasOne(IdProofType::class, 'id_proof_type_id', 'id_proof_type_id');
    }
}
