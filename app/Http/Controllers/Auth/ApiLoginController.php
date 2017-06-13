<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class ApiLoginController extends Controller
{
    private $client;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $usernamme = $request->get('username') ? $request->get('username') : $request->get('email');
        $request->request->add([
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'grant_type' => 'password',
            'username' => $usernamme,
            'password' => $request->get('password'),
            'scope' => '*'
        ]);
        $locale = app()->getLocale();
        $proxy = Request::create($locale.'/api/oauth/token', 'POST');
        $response =  Route::dispatch($proxy);
        $responseAsArray = json_decode($response->getcontent(), true);
        if (isset($responseAsArray['error'])) {
            return $responseAsArray;
        }
        $currentUser = \App\Model\Subscriber::where('email', $request->get('username'))->first();
        $currentUser =  ['user' => $this->parseUser($currentUser)];
        $endResponse = array_merge($responseAsArray, $currentUser);
        return $endResponse;
    }

    public function confirm($id, $token)
    {
        $user = $this->userRepository->find($id);
        if ($user->confirmation_token == $token) {
            $created = Carbon::parse($user->created_at);
            $now = Carbon::now();
            $diff = $now->diffInSeconds($created);
            if ($diff > config('app.register.token_ttl')) {
                return Response::json(['errors' => 'The confirmation token is expired']);
            }
            $user->enabled = true;
            $user->confirmation_token = null;
            $user->save();
        } else {
            return Response::json(['errors' => 'The confirmation token is error']);
        }
    }

    private function parseUser($user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'last_connexion' => $user->last_connexion,
            'email' => $user->email,
        ];
    }
}
