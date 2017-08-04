<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\updateProfileRequest;
use App\Model\CandidateProfile;
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
        try {
            $profile = Auth::user()->profiles->first();
            $response = [];
            if ($request->has('job')) {
                $response['job'] = $this->candidateProfileService->saveJobs($request->get('job'), $profile);
            } elseif ($request->exists('job') && $request->get('job') == '') {
                $response['job'] = $this->candidateProfileService->saveJobs(null, $profile);
            }

            if ($request->has('skills')) {
                $response['skills'] =  $this->candidateProfileService->saveSkills($request->get('skills'), $profile);
            }

            if ($request->has('skills_levels')) {
                $response['skills_levels'] = $this->candidateProfileService->saveSkillsLevels($request->get('skills_levels'), $profile);
            }

            if ($request->has('departement')) {
                $response['departement'] = $this->candidateProfileService->saveDepartement($request->get('departement'), $profile);
            }
            if ($request->has('mobility')) {
                $response['mobility'] = $this->candidateProfileService->saveMobility($request->get('mobility'), $profile);
            } elseif ($request->exists('mobility') && $request->get('mobility') == '') {
                $response['mobility'] = $this->candidateProfileService->saveMobility(false, $profile);
            }
            if ($request->has('states')) {
                $response['states'] = $this->candidateProfileService->saveStates($request->get('states'), $profile);
            }
            if ($request->has('social_links')) {
                $response['social_links'] = $this->candidateProfileService->saveSocialLinks($request->get('social_links'), $profile);
            }
            if ($request->has('favorite_salary')) {
                $response['favorite_salary'] = $this->candidateProfileService->saveFavoriteSalary($request->get('favorite_salary'), $profile);
            } elseif ($request->exists('favorite_salary') && $request->get('favorite_salary') == '') {
                $response['favorite_salary'] = $this->candidateProfileService->saveFavoriteSalary(null, $profile);
            }
            if ($request->has('synthesis')) {
                $response['synthesis'] = $this->candidateProfileService->saveSynthesis($request->get('synthesis'), $profile);
            } elseif ($request->exists('synthesis') && $request->get('synthesis') == '') {
                $response['synthesis'] = $this->candidateProfileService->saveSynthesis(null, $profile);
            }
            if ($request->has('favorite_skills')) {
                $response['favorite_skills'] = $this->candidateProfileService->saveFavoriteSkills($request->get('favorite_skills'), $profile);
            }
            if ($request->has('disponibility_date')) {
                $response['disponibility_date'] = $this->candidateProfileService->saveDisponibilityDate($request->get('disponibility_date'), $profile);
            } elseif ($request->exists('disponibility_date') && $request->get('disponibility_date') == '') {
                $response['disponibility_date'] = $this->candidateProfileService->saveDisponibilityDate(null, $profile);
            }
            if ($request->has('state_mobility')) {
                $response['state_mobility'] = $this->candidateProfileService->saveStateMobility($request->get('state_mobility'), $profile);
            }
            if ($request->has('banned_entreprises')) {
                $response['banned_entreprises'] = $this->candidateProfileService->saveBannedEntreprises($request->get('banned_entreprises'), $profile);
            }
            return Response::json($response);
        } catch (\Exception $ex) {
            return Response::json(['status' => false, 'message' => 'update error']);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * @method PUT
     */
    public function updateAll(updateProfileRequest $request)
    {
        try {
            $data = [];
            $profile = Auth::user()->profiles->first();
            $subscriberData['first_name'] = $request->get('first_name');
            $subscriberData['last_name'] = $request->get('last_name');
            $subscriberData['email'] = $request->get('email');
            $subscriberData['city'] = $request->get('city');
            $subscriberData['profile_type'] = 'C';
            $data['phone'] = $request->get('phone');
            $data['lookingforjob'] = $request->has('lookingforjob');
            if ($request->get('job') !== null) {
                $data['job_id'] = $request->get('job');
            }
            if ($request->has('skills')) {
                $data['skills'] = json_encode($this->candidateProfileService->formatArray($request->get('skills')));
            }
            if ($request->has('skills_levels')) {
                $data['skills_level'] = json_encode($request->get('skills_levels'));
            }
            if ($request->has('departement')) {
                $data['department_id'] = $request->get('departement');
            }
            if ($request->has('mobility')) {
                $data['mobile'] = $request->get('mobility');
            }
            if ($request->has('states')) {
                $data['states'] = $this->candidateProfileService->formatArray(json_encode($request->get('states')));
            }
            if ($request->has('social_links')) {
                $data['web_presence'] = json_encode($request->get('social_links'));
            }
            if ($request->has('favorite_salary')) {
                $data['favorite_salary'] = $request->get('favorite_salary');
            }
            if ($request->has('synthesis')) {
                $data['synthesis'] = $request->get('synthesis');
            }
            if ($request->has('title')) {
                $data['title'] = $request->get('title');
            }
            if ($request->has('favorite_skills')) {
                $data['favorite_skills'] = json_encode($request->get('favorite_skills'));
            }
            if ($request->has('disponibility_date')) {
                $date['disponibility_date'] = Carbon::parse($request->get('disponibility_date'));
            }
            if ($request->has('state_mobility')) {
                $date['state_mobility'] = json_encode($request->get('state_mobility'));
            }
            if (
                $this->candidateProfileService->updateAll($data, $profile) &&
                $this->candidateProfileService->saveSubscriber($subscriberData, Auth::user())
            ) {
                $response = ['profile' => true];
            } else {
                $response = ['profile' => false];
            }
            return Response::json($response);
        } catch (\Exception $ex) {
            return Response::json($ex->getMessage());
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $profile = Auth::user()->profiles->first();
            $cProfile = [
                'id' => $profile->id,
                'skills' => $profile->present()->getSkills,
                'experience' => $profile->experiences,
                'educations' => $profile->educations,
                'phone' => $profile->phone,
                'department' => $profile->department,
                'job' => $profile->job,
                'favorite_salary' => $profile->favorite_salary,
                'disponibility_in' =>  $this->getReelTimeDisponibility($profile),
                'disponibility_date' => $this->disponibility_date,
                'states' => $profile->present()->getStates,
                'web_presence' => $profile->present()->getWebPresence,
                'synthesis' => $profile->synthesis,
                'mobile' => $profile->mobile,
                'profile' => $profile->profile,
                'cv' => $profile->present()->getCV,
                'avatar' => $profile->present()->getAvatar,
                'banned_enterprises' => $profile->present()->getBannesEnterprise,
                'created_at' => $profile->created_at,
                'updated_at' => $profile->updated_at
            ];
            return Response::json($cProfile);
        } catch (\Exception $ex) {
            return Response::json($ex->getMessage());
        }
    }

    /**
     * @param $profile
     * @return string
     * get the disponibility date in reel time
     * example : disponible in 3 month -- disponible in 20 days ...
     */
    private function getReelTimeDisponibility($profile)
    {
        $now = Carbon::now();
        $disponility = Carbon::parse($profile->disponibility_date);
        $disponilityDays = $disponility->diffInDays($now);
        $disponilityIn = null;
        if ($disponilityDays > 30) {
            return trans_choice('profile.disponibility_month', $disponility->diffInMonths($now), ['availability' => $disponility->diffInMonths($now)]);
        }
        if ($disponilityDays > 365) {
            return trans_choice('profile.disponibility_year', $disponility->diffInYears($now), ['availability' => $disponility->diffInYears($now)]);
        }
        return trans_choice('profile.disponibility_day', $disponility->diffInDays($now), ['availability' => $disponility->diffInDays($now)]);
    }
}
