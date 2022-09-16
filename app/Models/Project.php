<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'folder',
        'startdate',
        'enddate',
        'status',
        'scope',
    ];

    protected $with = ['questionaire', 'questionaire.users'];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'project_participants')->withPivot('pvcot', 'raci');
    }

    public function questionaire()
    {
        return $this->hasOne(Questionaire::class);
    }
}
