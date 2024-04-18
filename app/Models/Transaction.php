<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_date',
        'finish_date',
        'user_id',
        'membership_id',
        'snap_token',
        'status',
        'membership_active'
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
