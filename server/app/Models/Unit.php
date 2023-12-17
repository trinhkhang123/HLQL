<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trainee;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'unit_type', 'parent_unit_id'];

    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }
}
