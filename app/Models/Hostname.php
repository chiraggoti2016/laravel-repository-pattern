<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostname extends Model
{
    use HasFactory;

    public function cpu_count() {
        return $this->hasOne(CpuCount::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
    
    public function database() {
        return $this->hasMany(CpuCountDatabaseDetail::class)->where('db_type', 'ora');
    }

    public function details() {
        return $this->hasOne(CpuCountDetail::class);
    }

    public function disk() {
        return $this->hasMany(CpuCountDiskDetail::class);
    }

    public function memory() {
        return $this->hasMany(CpuCountMemoryDetail::class)->where('memory_type', 'Mem');
    }

    public function storage() {
        return $this->hasMany(CpuCountStorageDetail::class);
    }

    public function opdb_details() {
        //return $this->hasMany(OptionsPacksDatabaseDetail::class);
        return $this->hasOne(OptionsPacksDatabaseDetail::class);
    }
 
    public function op_multitenants() {
        return $this->hasMany(OptionsPacksMultitenant::class);
    }

    public function parameter_details() {
        return $this->hasMany(OptionsPacksParameterDetail::class);
    }
  
    public function product() {
        return $this->hasMany(OptionsPacksProduct::class);
    } 

    public function product_details() {
        return $this->hasMany(OptionsPacksProductDetail::class);
    }

    public function usage_database() {
        return $this->hasMany(UsageDatabase::class)->where('cpu', 'all');
    }

    public function usage_pgpgins() {
        return $this->hasMany(UsagePgpgin::class);   
    }

    public function usage_procs() {
        return $this->hasMany(UsageProc::class);
    }
}
