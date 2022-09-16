<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionaire extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'startdate',
        'enddate',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, QuestionaireUser::class);
    }

    public function questionaire_questions()
    {
        return $this->hasMany(QuestionaireQuestion::class);
    }

}
