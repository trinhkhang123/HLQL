<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hocvien extends Model
{
    use HasFactory;
    protected $table = 'hocviens';
    protected $fillable = ['HoTen', 'CapBac', 'DonVi', 'TenLop', 'ThoiGianBatDau'];

    public function donvi()
    {
        return $this->belongsTo(Donvi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
