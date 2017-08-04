<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 04/08/17
 * Time: 15:37
 */

namespace app\Repositories\Criteria;

use App\Repositories\Contracts\Criteria;
use App\Repositories\Contracts\IRepository;
use Illuminate\Support\Facades\Auth;

class CandidateHitCriteria extends Criteria
{
    public function apply($model, IRepository $repository)
    {
        $profile = Auth::user()->profiles->first();
        return $model->where('c_profile_id', $profile->id);
    }
}
