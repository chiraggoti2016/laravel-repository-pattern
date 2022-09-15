<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaireQuestion extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'input',
        'depend',
        'question_id',
        'questionaire_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'input' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function questionaire()
    {
        return $this->belongsTo(Questionaire::class);
    }
}
