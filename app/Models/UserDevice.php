<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'device_name',
        'ip_address',
        'status',
    ];

    /**
     * Relasi: device milik user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
