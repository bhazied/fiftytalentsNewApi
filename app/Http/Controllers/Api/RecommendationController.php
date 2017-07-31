<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RecommendationRequest;
use App\Mail\AddRecommendation;
use App\Model\Recommendation;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class RecommendationController extends Controller
{
    /**
     * @var RecommendationRepository
     */
    private $recommendationRepository;

    /**
     * RecommendationController constructor.
     * @param RecommendationRepository $recommendationRepository
     */
    public function __construct(RecommendationRepository $recommendationRepository)
    {
        $this->recommendationRepository = $recommendationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriber = Auth()->user();
        $inlineCount =  $this->recommendationRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->findBy('c_profile_id', $subscriber->profiles->first()->id)
            ->count();
        $results = $this->recommendationRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->findBy('c_profile_id', $subscriber->profiles->first()->id);
        return Response::json(compact('inlineCount', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecommendationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['salt'] = Str::random(120);
            $recommendation = $this->recommendationRepository->create($data);
            Mail::to($recommendation->email)
                ->send(new AddRecommendation(Auth::user(), $recommendation));
            DB::commit();
            return Response::json(['status' => true, 'result' => $recommendation]);
        } catch (\Exception $ex) {
            DB::rollback();
            return Response::json(['status' => false, 'message' => 'Recommendation add error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function show(Recommendation $recommendation)
    {
        return Response::Json(['status' => true, 'result' => $recommendation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function edit(Recommendation $recommendation)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function update(RecommendationRequest $request, Recommendation $recommendation)
    {
        try {
            $data = $request->all();
            $result = $this->recommendationRepository->update($data, $recommendation->id, $this->recommendationRepository->getModelKeyName());
            if ($result) {
                return Response::json(['status' => true, 'result' => $this->recommendationRepository->find($recommendation->id) ]);
            }
            return Response::json(['status' => false, 'message' => 'Experience update error' ]);
        } catch (\Exception $ex) {
            return Response::json(['status' => false, 'message' => 'Experience update error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recommendation $recommendation)
    {
        if ($this->recommendationRepository->delete($recommendation->id)) {
            return ['status' => true, "message" => "Recommendation deleted"];
        }
        return ['status' => false, "message" => "Recommendation not deleted"];
    }
}
