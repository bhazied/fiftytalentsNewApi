<?php

namespace App\Http\Controllers\Api;

use App\Model\Education;
use App\Repositories\EducationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $subscriber = Auth()->user();
        $inlineCount =  $this->educationRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->findBy('c_profile_id',$subscriber->profiles->first()->id)
            ->count();
        $results = $this->educationRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
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
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $subscriber = Auth()->user();
            $orderCount = $this->educationRepository->findBy('c_profile_id',$subscriber->profiles->first()->id)->count();
            $data['order'] = $orderCount+1;
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
            $myEducations = Auth::user()->profiles->first()->educations();
            if(!$myEducations->get()->contains($education)){
                return ['status' => false, "message" => "Not authorize to delete this education"];
            }
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
        $myEducations = Auth::user()->profiles->first()->educations();
        if(!$myEducations->get()->contains($education)){
            return ['status' => false, "message" => "Not authorize to delete this education"];
        }
        if($this->educationRepository->delete($education->id)){
            return ['status' => true, "message" => "Education deleted"];
        }
        return ['status' => false, "message" => "Education not deleted"];
    }
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
                $exp = $profile->educations->where('id', $id)->first();
                if(!$exp){
                    DB::rollback();
                    return Response::json(['status' => true, 'message' => 'keep calm']);
                }
                if( !$this->educationRepository->update(['order' => $order], $id, $this->educationRepository->getModelKeyName()) ){
                    DB::rollback();
                    return Response::json(['status' => false, 'message' => 'Education not ordred totaly']);
                }
            }
            DB::commit();
            return Response::json(['status' => true, 'message' => 'Education order updates']);
        }catch(\Exception $ex){
            DB::rollback();
            return Response::json($ex->getMessage());
            return Response::json(['status' => false, 'message' => 'Education with new order not found']);
        }
    }
}
