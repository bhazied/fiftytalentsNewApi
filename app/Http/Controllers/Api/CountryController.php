<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CountryRequest;
use App\Jobs\ImageJob;
use App\Repositories\CountryRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

/**
 * Class CountryController
 * @package App\Http\Controllers\Api
 */
class CountryController extends Controller
{
    /**
     * @var Repository
     */
    private $countryRepository;

    /**
     * CountryController constructor.
     * @param Repository $countryRepository
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }


    /**
     * @return mixed
     */
    public function index()
    {
        $inlineCount =  $this->countryRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))->count();
        $results = $this->countryRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'))
            ->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'))
            ->with(['users'])
            ->lists();
        return Response::json(compact('inlineCount', 'results'));
    }

    /**
     * @param $country
     * @return mixed
     */
    public function show($country)
    {
        return \Response::json($this->countryRepository->find($country));
    }

    /**
     * @param CountryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        $country = $this->countryRepository->create($request->all());

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $file = $image->move(public_path('uploads/countries'), $image->getClientOriginalName());
            $imageJob = new ImageJob($file->getRealPath(), 'Country', $country);
            $imageJob->delay(Carbon::now()->addSecond(10));
            $this->dispatch($imageJob);
        }
        return Response::json($country);
    }

    /**
     * @param countryRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        return $this->getUpdateResponse($this->countryRepository->update($request->all(), $id, 'id'), 'Country');
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->getDestroyResponse($this->countryRepository->delete($id), 'Country');
    }
}
