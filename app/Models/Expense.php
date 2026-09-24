<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi secara mass-assignment
    protected $guarded = ['id'];
}