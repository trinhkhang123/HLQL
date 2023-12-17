<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trainee;
class TraineeAssessment extends Model
{
    use HasFactory;
    protected $fillable = ['trainee_id', 'course_id', 'attendance_score', 'regular_score', 'exam_score'];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
        
    }
}
