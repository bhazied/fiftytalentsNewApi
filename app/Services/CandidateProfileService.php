<?php

namespace App\Services;

use App\Model\CandidateProfile;
use App\Model\Subscriber;
use App\Repositories\CandidateProfileRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\JobRepository;
use App\Repositories\SkillRepository;
use App\Repositories\SubscriberRepository;

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

    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;

    public function __construct(
        SkillRepository $skillRepository,
        JobRepository $jobRepository,
        DepartmentRepository $departmentRepository,
        CandidateProfileRepository $candidateProfileRepository,
        SubscriberRepository $subscriberRepository
    )
    {
        $this->skillRepository = $skillRepository;
        $this->jobRepository = $jobRepository;
        $this->departementRepository = $departmentRepository;
        $this->candidateProfileRepository = $candidateProfileRepository;
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * @param $job
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveJobs($job, CandidateProfile $profile)
    {
        return $this->updatePatch(['job_id' => $job], $profile);
    }

    /**
     * @param $skills
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveSkills($skills, CandidateProfile $profile)
    {
        $formatedSkill = $this->formatArray($skills);
        $skills = json_encode($formatedSkill);
        return $this->updatePatch(['skills' => $skills], $profile);
    }

    /**
     * @param $departement
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveDepartement($departement, CandidateProfile $profile)
    {
        return $this->updatePatch(['department_id' => $departement], $profile);
    }

    /**
     * @param $skillsLevels
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveSkillsLevels($skillsLevels, CandidateProfile $profile)
    {
        $skillsLevels = json_encode($skillsLevels);
        return $this->updatePatch(['skills_level' => $skillsLevels], $profile);
    }

    /**
     * @param $mobility
     * @param CandidateProfile $profile
     */
    public  function saveMobility($mobility, CandidateProfile $profile)
    {
        return $this->updatePatch(['mobile' => $mobility], $profile);
    }

    /**
     * @param $states
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveStates($states, CandidateProfile $profile)
    {
        $formatedStates = $this->formatArray($states);
        $states = json_encode($formatedStates);
        return $this->updatePatch(['states' => $states], $profile);
    }

    /**
     * @param $socialLinks
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveSocialLinks($socialLinks, CandidateProfile $profile)
    {
        $socialLinks = json_encode($socialLinks);
        return $this->updatePatch(['web_presence' => $socialLinks], $profile);
    }

    /**
     * @param $salary
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveFavoriteSalary($salary, CandidateProfile $profile)
    {
        return $this->updatePatch(['favorite_salary' => $salary], $profile);
    }

    /**
     * @param $synthesis
     * @param CandidateProfile $profile
     * @return bool
     */
    public function saveSynthesis($synthesis, CandidateProfile $profile)
    {
        return $this->updatePatch(['synthesis' => $synthesis], $profile);
    }

    /**
     * @param $data
     * @param CandidateProfile $profile
     * @return bool
     */
    private function updatePatch($data, CandidateProfile $profile)
    {
        $updated = $this->candidateProfileRepository->update($data, $profile->id, $this->candidateProfileRepository->getModelKeyName());
        return ($updated == 1);
    }

    /**
     * @param $data
     * @param CandidateProfile $profile
     * @return bool
     * one sql request executed, used for the PUT http verbs
     */
    public function updateAll($data, CandidateProfile $profile)
    {
        $updated = $this->candidateProfileRepository->update($data, $profile->id, $this->candidateProfileRepository->getModelKeyName());
        return ($updated == 1);
    }

    /**
     * @param $data
     * @param Subscriber $subscriber
     * @return bool
     */
    public function saveSubscriber($data, Subscriber $subscriber)
    {
        $updated = $this->subscriberRepository->update($data, $subscriber->id, $this->subscriberRepository->getModelKeyName());
        return ($updated == 1);
    }

    /**
     * @param $input
     * @return array
     */
    public function formatArray($input){
        $output = [];
        foreach ($input as $data){
            $output[$data] = $data;
        }
        return $output;
    }

}