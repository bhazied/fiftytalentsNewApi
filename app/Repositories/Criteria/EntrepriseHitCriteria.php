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

class EntrepriseHitCriteria extends Criteria
{
    public function apply($model, IRepository $repository)
    {
        $profile = Auth::user()->e_profiles->first();
        return $model->where('e_profile_id', $profile->id);
    }
}
