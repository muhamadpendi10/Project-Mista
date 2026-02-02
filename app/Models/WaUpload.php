<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WaUpload extends Model
{
    protected $table = 'wa_uploads';

    protected $fillable = [
        'user_id',
        'filename',
        'total_rows',
        'created_at',
        'updated_at',
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
