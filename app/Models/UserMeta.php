<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_meta_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_first_name',
        'user_middle_name',
        'user_last_name',
        'user_dob',
        'user_gender',
        'id_proof_type_id',
        'user_address',
        'user_id_number',
        'user_id_image',
        'user_id',
        'created_by'
    ];

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'user_id');

    }

}
