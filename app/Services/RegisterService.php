<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 03/08/17
 * Time: 16:48
 */

namespace App\Services;

use App\Repositories\CandidateProfileRepository;
use App\Repositories\JobRepository;
use App\Repositories\SponsorshipRepository;
use App\Repositories\SubscriberRepository;
use App\Repositories\TeamRepository;

class RegisterService
{

    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;
    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var CandidateProfileRepository
     */
    private $cProfileRepository;
    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * @var SponsorshipRepository
     */
    private $sponsorshipRepository;

    /**
     * RegisterService constructor.
     * @param SubscriberRepository $subscriberRepository
     * @param TeamRepository $teamRepository
     * @param CandidateProfileRepository $cProfileRepository
     * @param JobRepository $jobRepository
     * @param SponsorshipRepository $sponsorshipRepository
     */
    public function __construct(
        SubscriberRepository $subscriberRepository,
        TeamRepository $teamRepository,
        CandidateProfileRepository $cProfileRepository,
        JobRepository $jobRepository,
        SponsorshipRepository $sponsorshipRepository
    ) {
        $this->subscriberRepository = $subscriberRepository;
        $this->teamRepository = $teamRepository;
        $this->cProfileRepository = $cProfileRepository;
        $this->jobRepository = $jobRepository;
        $this->sponsorshipRepository = $sponsorshipRepository;
    }

    public function getRelatedTeam($email)
    {
        return $this->teamRepository->findBy('email', $email)->first();
    }

    public function saveProfile($data)
    {
        return $this->cProfileRepository->create($data);
    }

    public function saveSubscriber($data)
    {
        return $this->subscriberRepository->create($data);
    }

    public function getSponsored($token)
    {
        return $this->sponsorshipRepository->findBy('token', $token)->first();
    }
}
