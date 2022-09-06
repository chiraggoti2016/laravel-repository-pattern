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
        'customers_count',
        'ola_engagements_count',
        'completed',
        'cancelled',
    ];
    
    public function getCustomersCountAttribute() { return 0; }
    public function getOlaEngagementsCountAttribute() { return 0; }
    public function getCompletedAttribute() { return 0; }
    public function getCancelledAttribute() { return 0; }

    public function users()
    {
        return $this->belongsToMany(User::class, 'partner_users');
    }

    // public function customers()
    // {
    //     return $this->belongsToMany(User::class, 'partner_customers');
    // }
}
