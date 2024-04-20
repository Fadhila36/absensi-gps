<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'nik',
        'tgl_presensi',
        'jam_in',
        'jam_out',
        'foto_in',
        'foto_out',
        'lokasi_in',
        'lokasi_out'
    ];

    protected $casts = [
        'tgl_presensi' => 'date',
        'jam_in' => 'datetime:H:i:s', // Cast kolom 'jam_in' menjadi tipe data datetime dengan format 'H:i:s'
        'jam_out' => 'datetime:H:i:s' // Cast kolom 'jam_out' menjadi tipe data datetime dengan format 'H:i:s'
    ];
    public $timestamps = false; 
}
