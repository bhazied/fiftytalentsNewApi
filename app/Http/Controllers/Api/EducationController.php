<?php

namespace App\Http\Controllers\Api;

use App\Model\Education;
use App\Repositories\EducationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class EducationController extends Controller
{
    /**
     * @var EducationRepository
     */
    private $educationRepository;

    public function __construct(EducationRepository $educationRepository)
    {
        $this->educationRepository = $educationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inlineCount =  $this->educationRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))->count();
        $results = $this->educationRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
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
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $data['order'] = '';
            $education =  $this->educationRepository->create($data);
            return Response::json(['status' => true, 'result' => $education]);
        }
        catch (\Exception $ex){
            return Response::json(['status' => false, 'message' => 'Education add error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        return $education;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Education $education)
    {
        try{
           $data = $request->all();
            $this->educationRepository->update($data, $education->id, $this->educationRepository->getModelKeyName());
            return Response::json(['status' => true, 'result' => $this->educationRepository->find($education->id) ]);
        }
        catch (\Exception $ex){
            return Response::json(['status' => false, 'message' => 'Education update error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $education)
    {
        if($this->educationRepository->delete($education->id)){
            return ['status' => true, "message" => "Education deleted"];
        }
        return ['status' => false, "message" => "Education not deleted"];
    }

    public function order(Request $request, Education $education)
    {
        $oldOrder = $request->get('oldOrder');
        $newOrder = $request->get('newOrder');
        $currentSubscriber = Auth::user()->CandidateProfile;
        $changedWith = $this->educationRepository->findWhere([ ['order', '=', $newOrder],['subscriber_id', '=', $currentSubscriber->id] ])->first();
        $oldOrder = ['order' => $oldOrder];
        $newOrder = ['order' => $newOrder];
        $this->educationRepository->update($oldOrder, $changedWith->id, $this->educationRepository->getModelKeyName());
        $this->educationRepository->update($newOrder, $education->id, $this->educationRepository->getModelKeyName());
    }
}
