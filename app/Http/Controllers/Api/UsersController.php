<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Users\AddUsersRequest;
use App\Http\Requests\Api\Users\UpdateUsersRequest;
use App\Contracts\UserContract;
use App\Http\Requests\Api\Users\EmailAlreadyExistsRequest;
use App\Http\Requests\Api\Users\ChangePasswordRequest;

class UsersController extends Controller
{
	private $userService;

	public function __construct(UserContract $userService)
	{
		$this->userService = $userService;
	}

	public function index(Request $request)
	{
		$res  = $this->userService->all($request->all());
		return $this->sendResponse($res);
	}

	public function create(AddUsersRequest $request)
	{
		$data = $request->all();

		$res  = $this->userService->create($data);
		return $this->sendResponse($res);
	}

	public function update(UpdateUsersRequest $request)
	{
		$res  = $this->userService->update($request->all(), $request->id);
		return $this->sendResponse($res);
	}

	public function show($id)
	{
		$res  = $this->userService->show($id);
		return $this->sendResponse($res);
	}

	public function destroy($id)
	{
		$res=$this->userService->delete($id);
		return $this->sendResponse($res);
    }

	public function emailAlreadyExists(EmailAlreadyExistsRequest $request) { 
		return $this->sendResponse(); 
	}

	public function resend(ResendRequest $request, $user) { 
		$res=$this->userService->resend($request, $user);
		return $this->sendResponse($res); 
	}

	public function changePassword(ChangePasswordRequest $request) { 
		$res=$this->userService->changePassword($request);
		return $res['status'] === 200 ? $this->sendResponse($res) : $this->sendError([], $res['message'], $res['status']); 
	}
}
