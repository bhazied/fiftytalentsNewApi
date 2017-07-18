<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 01/05/17
 * Time: 17:34
 */

namespace App\Repositories\Contracts;

interface IRepositoryCriteria
{
    public function skipCriteria($status = true);

    public function getCriteria();

    public function getByCriteria(Criteria $criteria);

    public function pushCriteria($criteria);

    public function applyCriteria();

    public function resetCriteria();

    public function resetModel();
}
