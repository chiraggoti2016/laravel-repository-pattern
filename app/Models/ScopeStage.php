<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScopeStage extends Model
{
    use HasFactory;

    protected $timestampes = false;

    public function project_stage()
    {
        return $this->hasOne(ProjectStage::class);
    }

    public function scopeModel()
    {
        return $this->belongsTo(Scope::class, 'scope', 'slug');
    }
}
