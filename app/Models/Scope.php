<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    use HasFactory;

    protected $timestampes = false;

    public function stages()
    {
        return $this->hasMany(ScopeStage::class, 'scope', 'slug');
    }

}
