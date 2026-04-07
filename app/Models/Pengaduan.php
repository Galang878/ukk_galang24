<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_pengaduan',
        'isi_laporan',
        'foto',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class);
    }

    public function latestTanggapan()
    {
        return $this->hasOne(Tanggapan::class)->latestOfMany();
    }
}