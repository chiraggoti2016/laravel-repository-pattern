<?php
namespace App\Repositories;

use App\Models\Scope;
use App\Contracts\ScopeContract;

class ScopeRepository extends BaseRepository implements ScopeContract
{
    function __construct() {
        parent::__construct(new Scope);
    }

	public function listBySlug() {
        return parent::all()->keyBy('slug');
    }
}

?>
