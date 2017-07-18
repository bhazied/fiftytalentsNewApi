<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ExperienceRequest;
use App\Model\Experience;
use App\Repositories\ExperienceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Mockery\CountValidator\Exception;

class ExperienceController extends Controller
{
    /**
     * @var ExperienceRepository
     */
    private $experienceRepository;

    /**
     * ExperienceController constructor.
     * @param ExperienceRepository $experienceRepository
     */
    public function __construct(ExperienceRepository $experienceRepository)
    {
        $this->experienceRepository = $experienceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriber = Auth()->user();
        $inlineCount =  $this->experienceRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->findBy('c_profile_id',$subscriber->profiles->first()->id)
            ->count();
        $results = $this->experienceRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->findBy('c_profile_id',$subscriber->profiles->first()->id);
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
    public function store(ExperienceRequest $request)
    {
        try{
            $data = $request->all();
            $subscriber = Auth()->user();
            $orderCount = $this->experienceRepository->findBy('c_profile_id',$subscriber->profiles->first()->id)->count();
            $data['order'] = $orderCount+1;
            $experience =  $this->experienceRepository->create($data);
            return Response::json(['status' => true, 'result' => $experience]);
        }
        catch (\Exception $ex){
            return Response::json(['status' => false, 'message' => 'Experience add error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        return $experience;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        try{
            $data = $request->all();
            $result = $this->experienceRepository->update($data, $experience->id, $this->experienceRepository->getModelKeyName());
            if($result){
                return Response::json(['status' => true, 'result' => $this->experienceRepository->find($experience->id) ]);
            }
            return Response::json(['status' => false, 'message' => 'Experience update error' ]);
        }
        catch (\Exception $ex){
            return Response::json(['status' => false, 'message' => 'Experience update error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        if($this->experienceRepository->delete($experience->id)){
            return ['status' => true, "message" => "Experience deleted"];
        }
        return ['status' => false, "message" => "Experience not deleted"];
    }

    /**
     * @param Request $request
     * @param Experience $experience
     * @return mixed
     */
    /*public function order(Request $request, Experience $experience)
    {
        $oldOrder = $request->get('oldOrder');
        $newOrder = $request->get('newOrder');
        $profile = Auth::user()->profiles->first();
        $changedWith = $this->experienceRepository->findWhere([ ['order', '=', $newOrder],['c_profile_id', '=', $profile->id] ])->first();
        if(!is_null($changedWith)) {
            $old = ['order' => $oldOrder];
            $new = ['order' => $newOrder];
            $this->experienceRepository->update($new, $experience);
            $this->experienceRepository->update($old, $changedWith);

            return Response::json(['status' => true, 'message' => 'Education order updates']);
        }
        else{
            return Response::json(['status' => false, 'message' => 'Education with new order not found']);
        }
    }*/

    /**
     * @param Request $request
     */
    public function order(Request $request)
    {
        $profile = Auth::user()->profiles->first();
        $orders = $request->get('orders');
        $ids = array_keys($orders);
        try{
            DB::beginTransaction();
            foreach ($orders as $id => $order)
            {
                $exp = $profile->experiences->where('id', $id)->first();
                if(!$exp){
                    DB::rollback();
                    return Response::json(['status' => true, 'message' => 'keep calm']);
                }
                if( !$this->experienceRepository->update(['order' => $order], $id, $this->experienceRepository->getModelKeyName()) ){
                    DB::rollback();
                    return Response::json(['status' => false, 'message' => 'Experience not ordred totaly']);
                }
            }
            DB::commit();
            return Response::json(['status' => true, 'message' => 'Experience order updates']);
        }catch(\Exception $ex){
            DB::rollback();
            return Response::json($ex->getMessage());
            return Response::json(['status' => false, 'message' => 'Experience with new order not found']);
        }
    }
}
