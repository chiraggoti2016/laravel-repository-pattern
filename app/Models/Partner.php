<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelVueDatatableTrait;

class Partner extends Model
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
        'ola_engagements_count',
        'completed',
        'cancelled',
    ];
    

    public function getOlaEngagementsCountAttribute() { return 0; }
    
    public function getCompletedAttribute() { 
        return $this->customers()->withCount('projects')->whereHas('projects', function($q){
            return $q->where('status', 'completed');
        })->get()->sum('projects_count'); 
    }

    public function getCancelledAttribute() {     
        return $this->customers()->withCount('projects')->whereHas('projects', function($q){
            return $q->where('status', 'cancelled');
        })->get()->sum('projects_count'); 
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'partner_users');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'partner_customers');
    }
}
