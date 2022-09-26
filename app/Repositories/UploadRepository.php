<?php
namespace App\Repositories;

use App\Models\Upload;
use App\Contracts\UploadContract;
use Illuminate\Http\Request;

class UploadRepository extends BaseRepository implements UploadContract
{
    function __construct() {
        parent::__construct(new Upload);
    }

	public function file(Request $request) {
        $file = $request->file('file');
        
        $destinationPath = 'uploads';
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        $type = $file->getMimeType();
        if($file->move($destinationPath, $filename)) {
            $upload = $this->create([
                'file'  => $filename,
                'type'  => $type,
            ]);
            return $upload;
        }
        return false;
    }
}

?>
