<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Notifications\registredUser;
use App\Repositories\CandidateProfileRepository;
use App\Repositories\JobRepository;
use App\Repositories\SubscriberRepository;
use App\Repositories\TeamRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ApiRegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;
    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var CandidateProfileRepository
     */
    private $cProfileRepository;
    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * ApiRegisterController constructor.
     * @param SubscriberRepository $subscriberRepository
     * @param TeamRepository $teamRepository
     * @param CandidateProfileRepository $cProfileRepository
     * @param JobRepository $jobRepository
     */
    public  function __construct(SubscriberRepository $subscriberRepository, TeamRepository $teamRepository, CandidateProfileRepository $cProfileRepository, JobRepository $jobRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
        $this->teamRepository = $teamRepository;
        $this->cProfileRepository = $cProfileRepository;
        $this->jobRepository = $jobRepository;
    }

    public function register(RegisterRequest $request)
    {
        $team = $this->teamRepository->findBy('email', $request->get('email'))->first();
        if($team){
            return Response::json(['error' => trans('register.team_exist')]);
        }
        $data = $request->except(['phone', 'cgu_candidate', 'job_id']);
        $user = $this->create($data);
        $dataProfile = $request->only(['phone', 'job_id']);
        $dataProfile['subscriber_id'] = $user->id;
        $this->profileCreate($dataProfile);
        event(new Registered($user));
        $user->notify(new registredUser());
        $request->request->add([
            'username' => $user->email,
            'password' => $data['password']
        ]);
        $locale = app()->getLocale();
        $proxy = Request::create($locale.'/api/candidate/auth', 'POST');
        return Route::dispatch($proxy);
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
        return $this->subscriberRepository->create($data);
    }

    protected function profileCreate($data)
    {
        $job = $this->jobRepository->find($data['job_id']);
        $data['department_id'] = $job->department_id;
        return $this->cProfileRepository->create($data);
    }
}
