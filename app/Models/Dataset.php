<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar Laravel mengizinkan penyimpanan data
    protected $fillable = [
        'nama_file',
        'path_file',
    ];
}