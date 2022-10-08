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

	public function listByScopeProject($project_id) {
        return $this->model->with(['project_stage' => function($q) use($project_id) {
            return $q->whereProjectId($project_id);
        }])->get()->mapToGroups(function ($item, $key) {
            return [$item['scope'] => $item];
        });
    }
}

?>
