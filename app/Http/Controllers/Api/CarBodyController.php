<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CarBodyRequest;
use App\Repositories\CarBodyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class CarBodyController extends Controller
{

    /**
     * @var CarBodyRepository
     */
    private $carBodyRepository;

    public function __construct(CarBodyRepository $carBodyRepository)
    {
        $this->carBodyRepository = $carBodyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inlineCount =  $this->carBodyRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))->count();
        $results = $this->carBodyRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->lists();
        return Response::json(compact('inlineCount', 'results'));
        return $this->carBodyRepository->with(['cars'])->lists();
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
    public function store(CarBodyRequest $request)
    {
        return $this->carBodyRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->carBodyRepository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarBodyRequest $request, $id)
    {
        return $this->carBodyRepository->update($request->all(), $id, 'id');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->carBodyRepository->delete($id)) {
            return ['status' => true, "message" => "deleted with success"];
        }
        return ['status' => false, "message" => "not deleted"];
    }
}
