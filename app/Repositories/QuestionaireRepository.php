<?php
namespace App\Repositories;

use App\Models\Questionaire;
use App\Models\QuestionaireQuestion;
use App\Models\QuestionaireUser;
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
            if($questionaire = $this->model->updateOrCreate([
                'project_id'    => $project_id,
            ],[
                'status'    => $data['status']
            ])) {
                if($questionaire->startdate === null) {
                    $questionaire->startdate = date('Y-m-d h:i:s');
                }

                if($questionaire->status === 'send' && $questionaire->enddate !== null) {
                    $questionaire->enddate = date('Y-m-d h:i:s');
                }
                
                $questionaire->save();
                                
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
                    // foreach($questionaire->users as $user) {
                    //     \Mail::send('Mails.send-questionaires', ['user' => $user, 'project_id' => $project_id], function($message) use($user){
                    //         $message->to($user->email);
                    //         $message->subject('Send Questionaires');
                    //     });
                    // }
                }

                return $questionaire;
            }
        } catch(\Throwable $e){
            // dd($e->getMessage());
            DB::rollBack();
            \Log::debug('Questionaire Repository : ',[ 'error' =>$e ]);
        }
        return false;
    }


}

?>
