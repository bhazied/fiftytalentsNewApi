<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 19/05/17
 * Time: 02:50
 */

namespace app\Repositories\Criteria;

use App\Repositories\Contracts\Criteria;
use App\Repositories\Contracts\IRepository;
use Illuminate\Http\Request;

class PagerCriteria extends Criteria
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, IRepository $repository)
    {
        $limit =  $this->request->get(config('app.repository.criteria.request.limit'), 10);
        $ofsset = $this->request->get(config('app.repository.criteria.request.offset'), 0);
        $model->skip($ofsset)->take($limit);
        return $model;
    }
}
