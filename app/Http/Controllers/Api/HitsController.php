<?php

namespace App\Http\Controllers\Api;

use App\Model\Hit;
use App\Services\HitService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Response;

class HitsController extends Controller
{
    /**
     * @var HitService
     */
    private $hitService;

    public function __construct(HitService $hitService)
    {
        $this->hitService = $hitService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $pager = ($request->has('limit') && $request->has('offset'));
        $criteria = ($request->has('filters') || $request->has('orderBy'));
        $enterprise = !(is_null($user->e_profiles->first()));
        $candidate = !(is_null($user->profiles->first()));
        $inlineCount =  $this->hitService->getCountHist($criteria, $enterprise, $candidate);
        $results = $this->hitService->getHits($pager, $criteria, $enterprise, $candidate);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Hit  $hit
     * @return \Illuminate\Http\Response
     */
    public function show(Hit $hit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Hit  $hit
     * @return \Illuminate\Http\Response
     */
    public function edit(Hit $hit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Hit  $hit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hit $hit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Hit  $hit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hit $hit)
    {
        //
    }
}
