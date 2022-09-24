<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\UploadContract;
use App\Http\Requests\Api\Uploads\FileRequest;

class UploadsController extends Controller
{
	private $uploadService;

	public function __construct(UploadContract $uploadService)
	{
		$this->uploadService = $uploadService;
	}

	public function file(FileRequest $request)
	{
		return $this->uploadService->file($request);
	}

}
