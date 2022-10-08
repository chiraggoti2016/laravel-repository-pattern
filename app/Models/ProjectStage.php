<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'startdate',
        'enddate',
        'status',
        'project_id',
        'scope_stage_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scope_stage()
    {
        return $this->belongsTo(ScopeStage::class);
    }

}
