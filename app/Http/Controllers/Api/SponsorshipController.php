<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SponsorshipRequest;
use App\Mail\sponsorshipEmail;
use App\Model\SponsorShip;
use App\Repositories\SponsorshipRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SponsorshipController extends Controller
{


    /**
     * @var SponsorshipRepository
     */
    private $sponsorshipRepository;

    public function __construct(SponsorshipRepository $sponsorshipRepository)
    {
        $this->sponsorshipRepository = $sponsorshipRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inlineCount =  $this->sponsorshipRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))->count();
        $results = $this->sponsorshipRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->scopeQuery(function ($query) {
                return $query->where('subscriber_id', Auth::user()->id);
            })
            ->lists();
        return Response::json(compact('inlineCount', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SponsorshipRequest $request)
    {
        try {
            if ($request->get('email') == Auth::user()->email) {
                return Response::json(['status' => false, 'message' => "You can sponsor yourself"]);
            }
            $data = $request->all();
            $data['token'] = Str::random(128);
            $data['subscriber_id'] = Auth::user()->id;
            $sponsorship = $this->sponsorshipRepository->create($data);
            Mail::to($sponsorship->email)
                ->later(Carbon::now()->addSecond(10), new sponsorshipEmail($sponsorship));
            return Response::json(['status' => true, 'result' => $sponsorship]);
        } catch (\Exception $ex) {
            return Response::json(['status' => false, 'message' => 'Sponsorship no added']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\SponsorShip  $sponsorShip
     * @return \Illuminate\Http\Response
     */
    public function show(SponsorShip $sponsorShip)
    {
        return  Response::json($sponsorShip);
    }

    /**
     * @param $token
     */
    public function check($token)
    {
        try {
            $sponsorship = $this->sponsorshipRepository->findBy('token', $token)->first();
            if ($sponsorship->status === 'waiting') {
                return Response::json(['status' => true, 'sponsorship' => $sponsorship]);
            }
            return Response::json(['status' => false, 'sponsorship' => null]);
        } catch (\Exception $ex) {
            return Response::json(['status' => false, 'sponsorship' => null]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\SponsorShip  $sponsorShip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SponsorShip $sponsorShip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\SponsorShip  $sponsorShip
     * @return \Illuminate\Http\Response
     */
    public function destroy(SponsorShip $sponsorShip)
    {
        //
    }
}
