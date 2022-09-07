<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelVueDatatableTrait;

class Country extends Model
{
    use HasFactory, LaravelVueDatatableTrait;

	protected $fillable = [
		'country_name','sortname','timezone', 'country_lat', 'country_lng',
	];
}
