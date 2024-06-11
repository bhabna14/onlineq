<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdProofType extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_proof_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_proof',
        'created_by'
    ];
}
