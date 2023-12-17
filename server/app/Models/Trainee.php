<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\User;

class Trainee extends Model
{
    
    protected $fillable = ['full_name', 'rank', 'unit_id', 'class_name', 'start_date','phone','address','year_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function assessments()
    {
        return $this->hasMany(TraineeAssessment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
