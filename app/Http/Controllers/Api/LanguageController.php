<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LanguageRequest;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class LanguageController extends Controller
{
    private $languageRepositiry;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepositiry = $languageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->languageRepositiry->lists();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $inlineCount =  $this->languageRepositiry->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))->count();
        $results = $this->languageRepositiry->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->lists();
        return Response::json(compact('inlineCount', 'results'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->languageRepositiry->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->languageRepositiry->update($request->all(), $id, 'id');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->languageRepositiry->delete($id);
    }
}
