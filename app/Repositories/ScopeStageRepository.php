<?php
namespace App\Repositories;

use App\Models\ScopeStage;
use App\Contracts\ScopeStageContract;

class ScopeStageRepository extends BaseRepository implements ScopeStageContract
{
    function __construct() {
        parent::__construct(new ScopeStage);
    }

	public function listByScope() {
        return $this->model->get()->mapToGroups(function ($item, $key) {
            return [$item['scope'] => $item];
        });
    }
}

?>
