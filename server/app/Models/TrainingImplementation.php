<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingImplementation extends Model
{
    use HasFactory;
    protected $fillable = ['trainee_id', 'equipment_id', 'implementation_time', 'result'];
}
