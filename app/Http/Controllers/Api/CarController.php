<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CarRequest;
use App\Repositories\CarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class CarController extends Controller
{

    /**
     * @var CarRepository
     */
    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inlineCount =  $this->carRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))->count();
        $results = $this->carRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->with(['carBrand', 'carModel', 'user'])
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
     * @param  CarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request)
    {
        return Response::json($this->carRepository->create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Response::json($this->carRepository->with(['carBrand', 'carModel', 'user'])->find($id));
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
     * @param  CarRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequest $request, $id)
    {
        return Response::json($this->carRepository->update($request->all(), $id, 'id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->carRepository->delete($id)) {
            return ['status' => true, "message" => "deleted with success"];
        }
        return ['status' => false, "message" => "not deleted"];
    }
}
