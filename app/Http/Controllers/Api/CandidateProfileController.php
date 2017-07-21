<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\updateProfileRequest;
use App\Services\CandidateProfileService;
use Carbon\Carbon;
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

    /**
     * @param Request $request
     * @return mixed
     * @method PATCH
     */
    public function update(Request $request)
    {
        try{
            $profile = Auth::user()->profiles->first();
            $response = [];
            if($request->has('job')){
                $response['job'] = $this->candidateProfileService->saveJobs($request->get('job'), $profile);
            }

            if($request->has('skills')){
                $response['skills'] =  $this->candidateProfileService->saveSkills($request->get('skills'), $profile);
            }

            if($request->has('skills_levels')){
                $response['skills_levels'] = $this->candidateProfileService->saveSkillsLevels($request->get('skills_levels'), $profile);
            }

            if($request->has('departement')){
                $response['departement'] = $this->candidateProfileService->saveDepartement($request->get('departement'), $profile);
            }
            if($request->has('mobility')){
                $response['mobility'] = $this->candidateProfileService->saveMobility($request->get('mobility'), $profile);
            }
            if($request->has('states')){
                $response['states'] = $this->candidateProfileService->saveStates($request->get('states'), $profile);
            }
            if($request->has('social_links')){
                $response['social_links'] = $this->candidateProfileService->saveSocialLinks($request->get('social_links'), $profile);
            }
            if($request->has('favorite_salary')){
                $response['favorite_salary'] = $this->candidateProfileService->saveFavoriteSalary($request->get('favorite_salary'), $profile);
            }
            if($request->has('synthesis')){
                $response['synthesis'] = $this->candidateProfileService->saveSynthesis($request->get('synthesis'), $profile);
            }
            if($request->has('favorite_skills')){
                $response['favorite_skills'] = $this->candidateProfileService->saveFavoriteSkills($request->get('favorite_skills'), $profile);
            }
            if($request->has('disponibility_date')){
                $response['disponibility_date'] = $this->candidateProfileService->saveDisponibilityDate($request->get('disponibility_date'), $profile);
            }
            return Response::json($response);
        }catch (\Exception $ex){
            //return Response::json(['status' => false, 'message' => 'update error']);
            return Response::json($ex->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * @method PUT
     */
    public function updateAll(updateProfileRequest $request)
    {
        try{
            $data = [];
            $profile = Auth::user()->profiles->first();
            $subscriberData['first_name'] = $request->get('first_name');
            $subscriberData['last_name'] = $request->get('last_name');
            $subscriberData['email'] = $request->get('email');
            $subscriberData['city'] = $request->get('city');
            $subscriberData['profile_type'] = 'C';
            $data['phone'] = $request->get('phone');
            $data['lookingforjob'] = $request->has('lookingforjob');
            if($request->get('job') !== null){
                $data['job_id'] = $request->get('job');
            }
            if($request->has('skills')){
                $data['skills'] = json_encode($this->candidateProfileService->formatArray($request->get('skills')));
            }
            if($request->has('skills_levels')){
                $data['skills_level'] = json_encode($request->get('skills_levels'));
            }
            if($request->has('departement')){
                $data['department_id'] = $request->get('departement');
            }
            if($request->has('mobility')){
                $data['mobile'] = $request->get('mobility');
            }
            if($request->has('states')){
                $data['states'] = $this->candidateProfileService->formatArray(json_encode($request->get('states')));
            }
            if($request->has('social_links')){
                $data['web_presence'] = json_encode($request->get('social_links'));
            }
            if($request->has('favorite_salary')){
                $data['favorite_salary'] = $request->get('favorite_salary');
            }
            if($request->has('synthesis')){
                $data['synthesis'] = $request->get('synthesis');
            }
            if($request->has('title')){
                $data['title'] = $request->get('title');
            }
            if($request->has('favorite_skills')){
                $data['favorite_skills'] = json_encode($request->get('favorite_skills'));
            }
            if($request->has('disponibility_date')){
                $date['disponibility_date'] = Carbon::parse($request->get('disponibility_date'));
            }
            if(
                $this->candidateProfileService->updateAll($data, $profile) &&
                $this->candidateProfileService->saveSubscriber($subscriberData, Auth::user())
            ){
                $response = ['profile' => true];
            }
            else{
                $response = ['profile' => false];
            }
            return Response::json($response);

        }catch (\Exception $ex){
            return Response::json($ex->getMessage());
        }
    }

}
