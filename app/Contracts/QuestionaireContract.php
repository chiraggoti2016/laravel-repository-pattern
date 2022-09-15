<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface QuestionaireContract extends BaseContract
{
    public function send($data, $project_id);
}
