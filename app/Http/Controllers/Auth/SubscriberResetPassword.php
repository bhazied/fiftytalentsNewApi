<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SubscribeResetPasswordRequest;
use App\Mail\SubscriberPasswordMail;
use App\Repositories\SubscriberRepository;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class SubscriberResetPassword extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
        $this->middleware('guest');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('subscribers');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(SubscribeResetPasswordRequest $request)
    {
        try {
            $subscriber = $this->subscriberRepository->findBy('email', $request->get('email'))->first();
            if (!$subscriber) {
                return Response::json(['status' => false, 'message' => 'no subscriber with this e-mail']);
            }
            $password = Str::random(config('app.reset_password.password_length'));
            Mail::to($request->get('email'))->send(new SubscriberPasswordMail(
                $subscriber,
                $request->get('email'),
                $password
            ));
            $this->subscriberRepository->update(['password' => bcrypt($password)], $subscriber->id, $this->subscriberRepository->getModelKeyName());
            return Response::json(['status' => true, 'message' => 'new password sent to your email']);
            return Response::json(['status' => true, 'message' => 'Error send new password']);
        } catch (\Exception $ex) {
            return Response::json(['status' => true, 'message' => $ex->getMessage()]);
            //return Response::json(['status' => true, 'message' => 'Error send new password']);
        }
    }
}
