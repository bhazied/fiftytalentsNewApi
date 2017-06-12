<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Notifications\registredUser;
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

    public  function __construct(SubscriberRepository $subscriberRepository, TeamRepository $teamRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
        $this->teamRepository = $teamRepository;
    }

    public function register(RegisterRequest $request)
    {
        $team = $this->teamRepository->findBy('email', $request->get('email'))->first();
        if($team){
            return Response::json(['error' => trans('register.team_exist')]);
        }
        $data = $request->except(['phone', 'cgu_candidate', 'job_id']);
        $user = $this->create($data);
        event(new Registered($user));
        $user->notify(new registredUser());
        //return redirect()->route('postLogin', ['username' => $user->email, 'password'=> $data['password']]);
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
}
