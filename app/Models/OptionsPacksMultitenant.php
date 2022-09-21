<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionsPacksMultitenant extends Model
{
    use HasFactory;

    public function cpu_count_database_detail() {
        return $this->belongsTo(CpuCountDatabaseDetail::class);
    }
}
