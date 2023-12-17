<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trainee;
class TrainingPlan extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'lesson_id', 'content_id', 'time', 'hours', 'target_trainee', 'hours_per_target'];

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class);
    }
}
