<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInteraction extends Model
{
    protected $guarded = ['id'];

    public function user() { return $this->belongsTo(User::class, 'user_id'); } // Pelanggan
    public function admin() { return $this->belongsTo(User::class, 'admin_id'); } // Admin
}