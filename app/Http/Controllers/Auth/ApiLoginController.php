<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $request->request->add([
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'grant_type' => 'password',
            'username' => $request->username,
            'password' => $request->password,
            'scope' => '*'
        ]);

        $proxy = Request::create('api/oauth/token', 'POST');
        $response =  Route::dispatch($proxy);
        $responseAsArray = json_decode($response->getcontent(), true);
        if (isset($responseAsArray['error'])) {
            return $responseAsArray;
        }
        $currentUser = \App\Model\User::where('email', $request->username)->first();
        $currentUser =  ['user' => $this->parseUser($currentUser)];
        $endResponse = array_merge($responseAsArray, $currentUser);
        return $endResponse;
    }

    public function confirm($id, $token)
    {
        //$user = $this->userRepository->findWhere(['id' => $id, 'confirmation_token'=> $token]);
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
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
