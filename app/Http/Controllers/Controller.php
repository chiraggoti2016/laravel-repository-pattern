<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function sendResponse($result = [])
	{
		return response()->json($result, 200);
	}

	public function sendError($errors=[], $errorMessage, $code = 500)
	{
        return response()->json([
            'success' => false,
            'errors' => count($errors)>0?$errors:null,
            'message' => $errorMessage,
        ], $code);
	}

	public function sendValidationError($field,$error, $code = 422, $errorMessages = [])
	{
		$response = [
			'errors' => [$field => $error],
			'message' => 'The given data was invalid.',
		];

		if(!empty($errorMessages)){
			$response['data'] = $errorMessages;
		}

		return response()->json($response, $code);
	}
}
