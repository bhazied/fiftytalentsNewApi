<?php

namespace App\Http\Controllers\Api;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class CustomAccessTokenController extends AccessTokenController
{
    /**
     * Hooks in before the AccessTokenController issues a token
     *
     *
     * @param  ServerRequestInterface $request
     * @return mixed
     */
    public function issueUserToken(ServerRequestInterface $request)
    {
        $httpRequest = request();
        
        if ($httpRequest->grant_type == 'password') {
            $user = User::where('email', $httpRequest->username)->first();
            //if ($user->enabled) {
                return $this->issueToken($request);
           /* } else {
                return Response::json(['error' => 'invalid_credentials', 'message' => 'The user credentials were incorrect.']);
            }*/
        }
    }
}
