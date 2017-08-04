<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 04/08/17
 * Time: 12:10
 */

namespace App\Services;

use App\Repositories\HitRepository;
use Illuminate\Support\Facades\App;

class HitService
{
    /**
     * @var HitRepository
     */
    private $hitRepository;

    public function __construct(HitRepository $hitRepository)
    {
        $this->hitRepository = $hitRepository;
    }

    /**
     * @param bool $pager
     * @param bool $criteria
     * @param bool $entreprise
     * @param bool $candidate
     * @return mixed
     */
    public function getHits($pager = false, $criteria = false, $entreprise = false, $candidate = false)
    {
        if ($pager) {
            $this->setPager();
        }
        if ($criteria) {
            $this->setRequestCriteria();
        }
        if ($entreprise) {
            $this->setEntrepriseCriteria();
        }
        if ($candidate) {
            $this->setCandidateCriteria();
        }
        return $this->hitRepository->lists();
    }

    /**
     * @param bool $criteria
     * @param bool $entreprise
     * @param bool $candidate
     * @return mixed
     */
    public function getCountHist($criteria = false, $entreprise = false, $candidate = false)
    {
        if ($criteria) {
            $this->setRequestCriteria();
        }
        if ($entreprise) {
            $this->setEntrepriseCriteria();
        }
        if ($candidate) {
            $this->setCandidateCriteria();
        }
        return $this->hitRepository->count();
    }

    private function setRequestCriteria()
    {
        $this->hitRepository->pushCriteria(App::make('\App\Repositories\Criteria\RequestCriteria'));
    }

    private function setPager()
    {
        $this->hitRepository->pushCriteria(App::make('\App\Repositories\Criteria\PagerCriteria'));
    }

    private function setCandidateCriteria()
    {
        $this->hitRepository->pushCriteria(App::make('\App\Repositories\Criteria\CandidateHitCriteria'));
    }
    private function setEntrepriseCriteria()
    {
        $this->hitRepository->pushCriteria(App::make('\App\Repositories\Criteria\EntrepriseHitCriteria'));
    }
}
