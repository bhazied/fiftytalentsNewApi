<?php

namespace App\Http\Controllers\Auth;

use App\Events\SponsorEvent;
use App\Http\Requests\RegisterRequest;
use App\Notifications\registredUser;
use App\Repositories\CandidateProfileRepository;
use App\Repositories\JobRepository;
use App\Repositories\SponsorshipRepository;
use App\Repositories\SubscriberRepository;
use App\Repositories\TeamRepository;
use App\Services\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ApiRegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var RegisterService
     */
    private $registerService;

    /**
     * ApiRegisterController constructor.
     * @param RegisterService $registerService
     */
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(RegisterRequest $request, $token = null)
    {
        $team = $this->registerService->getRelatedTeam($request->get('email'));
        if ($team) {
            return Response::json(['error' => trans('register.team_exist')]);
        }
        try {
            DB::beginTransaction();
            //$data = $request->except(['phone', 'cgv', 'job_id']);
            //$user = $this->create($data);
            $data = $request->except(['phone', 'cgv']);
            $user = $this->create($data);
            $dataProfile = $request->only(['phone']);
            $dataProfile['subscriber_id'] = $user->id;
            $this->registerService->saveProfile($dataProfile);
            event(new Registered($user));
            $sponsored = $this->registerService->getSponsored($token);
            if ($sponsored && $sponsored->status == 'waiting') {
                event(new SponsorEvent($sponsored));
            }
            $user->notify(new registredUser());
            $request->request->add([
                'username' => $user->email,
                'password' => $data['password']
            ]);
            $locale = app()->getLocale();
            $proxy = Request::create($locale.'/api/candidate/auth', 'POST');
            DB::commit();
            return Route::dispatch($proxy);
        } catch (\Exception $ex) {
            DB::rollback();
            return Response::json(['status' => false, 'message' => 'Registration error']);
        }
    }

    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $data['profile_type'] = 'C';
        $data['password'] = bcrypt($data['password']);
        $data['salt'] = Str::random(40);
        return $this->registerService->saveSubscriber($data);
    }
}
