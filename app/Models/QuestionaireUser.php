<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaireUser extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'questionaire_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questionaire()
    {
        return $this->belongsTo(Questionaire::class);
    }
}
