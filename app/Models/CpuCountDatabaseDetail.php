<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpuCountDatabaseDetail extends Model
{
    use HasFactory;

    public function options_packs_database_detail() {
        return $this->hasOne(OptionsPacksDatabaseDetail::class);
    }

    public function options_packs_multitenant() {
        return $this->hasMany(OptionsPacksMultitenant::class);
    }
}
