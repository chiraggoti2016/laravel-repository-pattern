<?php
namespace App\Repositories;

use App\Models\Questionaire;
use App\Models\QuestionaireQuestion;
use App\Models\QuestionaireUser;
use App\Models\Project;
use App\Models\ProjectStage;
use App\Contracts\QuestionaireContract;
use App\Http\Resources\Questionaire as QuestionaireResource;
use DB;

class QuestionaireRepository extends BaseRepository implements QuestionaireContract
{
    function __construct() {
        parent::__construct(new Questionaire);
    }

    function send($data, $project_id) {
        DB::beginTransaction();
        try {

            // set status
            if($project = Project::find($project_id)){
                $project->update(['status' => 'in progress']);
            }

            if($questionaire = $this->model->updateOrCreate([
                'project_id'    => $project_id,
            ],[
                'status'    => $data['status']
            ])) {

                $project_stage = ProjectStage::updateOrCreate([
                    "project_id"        => $project_id,
                    "scope_stage_id"    => $data['stage_id'],
                ],[
                    "status"            => $data['status'] == 'send' ? 'complete' : 'in progress',
                    "enddate"           => $data['status'] == 'send' ? date('Y-m-d h:i:s'):null,
                    
                ]);
                                
                // users
                foreach($data['emailTo'] as $userId) {
                    QuestionaireUser::updateOrCreate([
                        'questionaire_id' => $questionaire->id,
                    ],
                    [
                        'user_id'   => $userId,
                    ]);
                }

                foreach($data['questions'] as $questioncategory => $answers) {
                    foreach($answers as $answer) {
                        QuestionaireQuestion::updateOrCreate([
                            'questionaire_id'   => $questionaire->id,
                            'question_id'       => $answer['question_id'],              
                        ], $answer);
                    }
                }                
                
                DB::commit();

                $questionaire = $this->findData($questionaire->id);
                if($data['status'] === 'send'){
                    foreach($questionaire->users as $user) {
                        dispatch(new \App\Jobs\QuestionairesMailJob($user->email, ['user' => $user, 'project_id' => $project_id]));
                    }
                }

                return $questionaire;
            }
        } catch(\Throwable $e){
            DB::rollBack();
            \Log::debug('Questionaire Repository : ',[ 'error' =>$e ]);
            
            abort(422, $e->getMessage());
        }
        return false;
    }


}

?>
