<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelVueDatatableTrait;

class Customer extends Model
{
    use HasFactory, LaravelVueDatatableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'country',
        'added_by',
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'address' => [
            'searchable' => true,
        ],
        'country' => [
            'searchable' => true,
        ],
    ];

    protected $appends = [
        'oracle',
        'microsoft',
        'vmware',
        'sap',
    ];
    
    public function getOracleAttribute() { return true; }
    public function getMicrosoftAttribute() { return false; }
    public function getVmwareAttribute() { return false; }
    public function getSapAttribute() { return false; }

    public function users()
    {
        return $this->belongsToMany(User::class, 'customer_users');
    }
    
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'customer_projects');
    }
}
