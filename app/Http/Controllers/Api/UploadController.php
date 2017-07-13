<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UploadAvatarRequest;
use App\Http\Requests\UploadCvRequest;
use App\Jobs\avatarJob;
use App\Repositories\CandidateProfileRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    private $candidateProfileRepository;

    public function __construct(CandidateProfileRepository $candidateProfileRepository)
    {
        $this->candidateProfileRepository = $candidateProfileRepository;
    }

    public function CvUpload(UploadCvRequest $request)
    {
        $basePathUpload = $this->getBasePathUpload('cv');
        $file = $request->file('file');
        if(!file_exists($basePathUpload)){
            File::makeDirectory($basePathUpload, 0777, true);
        }
        $moved = $file->move($basePathUpload, $file->getClientOriginalName());
        if($moved){
            $fileinfo = [
                'filename' => $moved->getBasename(),
                'path' => $this->getRelativePath('cv')
            ];
            return Response::json(['status' => true, 'result'=>
                ['message' => 'Importation de votre cv réussie', 'file' => $fileinfo]
            ]);
        }

        return Response::json(['status' => false, 'message' => 'Error importation CV']);
    }

    public function avatarUpload(UploadAvatarRequest $request)
    {
        $basePathUpload = $this->getBasePathUpload('avatar');
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            if(!file_exists($basePathUpload)){
                File::makeDirectory($basePathUpload, 0777, true);
            }
            $moved = $image->move($basePathUpload, $image->getClientOriginalName());
            if($moved){
                $avatarJOb = new avatarJob($image->getClientOriginalName(),  $this->getBasePathUpload('avatar'), Auth::user());
                $avatarJOb->delay(Carbon::now()->addSecond(5));
                dispatch($avatarJOb);
                $fileinfo = [
                    'filename' => $moved->getBasename(),
                    'path' => $this->getRelativePath('avatar')
                ];
                return Response::json(['status' => true, 'result'=>
                    ['message' => 'Importation de votre avatar réussie', 'file' => $fileinfo]
                ]);
            }

            return Response::json(['status' => false, 'message' => 'Error importation Avatar']);
        }

    }

    private function getBasePathUpload($type){
        return public_path($this->getRelativePath($type));
    }

    private function getRelativePath($type){
        $user = Auth::user();
        return config('image.real_path') .DIRECTORY_SEPARATOR.getCustomerBaseDirectory($user->salt).$type;
    }
}
