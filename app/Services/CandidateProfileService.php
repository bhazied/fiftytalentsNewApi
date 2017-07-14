<?php

namespace App\Services;

use App\Model\CandidateProfile;
use App\Repositories\CandidateProfileRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\JobRepository;
use App\Repositories\SkillRepository;

class CandidateProfileService
{

    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * @var DepartmentRepository
     */
    private $departementRepository;

    /**
     * @var CandidateProfileRepository
     */
    private $candidateProfileRepository;

    public function __construct(
        SkillRepository $skillRepository,
        JobRepository $jobRepository,
        DepartmentRepository $departmentRepository,
        CandidateProfileRepository $candidateProfileRepository
    )
    {
        $this->skillRepository = $skillRepository;
        $this->jobRepository = $jobRepository;
        $this->departementRepository = $departmentRepository;
        $this->candidateProfileRepository = $candidateProfileRepository;
    }

    public function saveJobs($job, CandidateProfile $profile)
    {
       $updated =  $this->candidateProfileRepository->update(['job_id' => $job], $profile->id, $this->candidateProfileRepository->getModelKeyName());
        return ($updated != null);
    }

    public function saveSkills($skills, CandidateProfile $profile)
    {

    }

    public function saveDepartement($departement, CandidateProfile $profile)
    {

    }

    public function saveSkillsLevels($skillsLevels, CandidateProfile $profile)
    {

    }

}