<?php

namespace App\Http\Controllers\Api;

use App\Services\CandidateProfileService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CandidateProfileController extends Controller
{

    /**
     * @var CandidateProfileService
     */
    private $candidateProfileService;

    public function __construct(CandidateProfileService $candidateProfileService)
    {
        $this->candidateProfileService = $candidateProfileService;
    }

    public function update(Request $request)
    {
        try{
            $profile = Auth::user()->profiles->first();
            $response = [];
            if($request->get('job') !== null){
                $jobUpdat = $this->candidateProfileService->saveJobs($request->get('job'), $profile);
                if($jobUpdat){
                    $response['job'] = true;
                }
                $response['job'] = false;
            }

            if($request->get('skills') !== null){
               $skillUpdate =  $this->candidateProfileService->saveSkills($request->get('skills'), $profile);
                if($skillUpdate){
                    $response['skills'] = true;
                }
                $response['skills'] = false;
            }

            if($request->get('skills_levels') !== null){
                $slUpdate = $this->candidateProfileService->saveSkillsLevels($request->get('skills_levels'), $profile);
            }

            if($request->get('departement') !== null){
                $this->candidateProfileService->saveDepartement($request->get('departement', $profile));
            }
            return Response::json($response);
        }catch (\Exception $ex){
            return Response::json(['status' => false, 'message' => 'update error']);
        }
    }

}
