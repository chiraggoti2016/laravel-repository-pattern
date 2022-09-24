<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file',
        'type',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute() { 
        return  asset('uploads/'.$this->file);
    }
}
