<?php
/**
 * Created by PhpStorm.
 * User: Zied Ben Hadj Amor
 * Date: 31/07/17
 * Time: 12:31
 */

namespace App\Presenters;

use App\Repositories\SkillRepository;
use App\Repositories\StateRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Laracasts\Presenter\Presenter;

class CandidateProfilePresenter extends Presenter
{

    /**
     * @return array|string
     * get Skills by level and favorite skills
     */
    public function getSkills()
    {
        try {
            $skills = json_decode($this->skills_level);
            $favorite_skills = $this->favorite_skills;
            $skillRepository = resolve(SkillRepository::class);
            $skillsResult = [];
            foreach ($skills as $skill => $level) {
                $item = $skillRepository->find($skill);
                $tmp = [
                    'title' => is_null($item) ? 'N/A' : $item->title,
                    'id' => is_null($item) ? $skill : $item->id,
                    'level' => $level,
                ];
                if (!is_null($favorite_skills)) {
                    $tmp['favorite'] = array_has($favorite_skills, $skill);
                } else {
                    $tmp['favorite'] = false;
                }
                array_push($skillsResult, $tmp);
            }
            return $skillsResult;
        } catch (\Exception $ex) {
            return $ex->getMessage();
            return [];
        }
    }

    /**
     * @return array
     * get States
     */
    public function getStates()
    {
        try {
            $states = $this->states;
            $stateMobility = $this->mobility_by_state;
            $stateRepository = resolve(StateRepository::class);
            $statesResult = [];
            foreach ($states as  $id) {
                $state = $stateRepository->find($id);
                if (!is_null($state)) {
                    $tmp = [
                        'id' => $state->id,
                        'name' => $state->name,
                        'country' => $state->country->name
                    ];
                    if (!is_null($stateMobility)) {
                        $tmp['mobility'] = array_has($stateMobility, $id) ? $stateMobility[$id] : 0;
                    }
                    array_push($statesResult, $tmp);
                }
            }
            return $statesResult;
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * @return array
     * get Web presence
     */
    public function getWebPresence()
    {
        try {
            $socials = json_decode($this->web_presence);
            $profileNetwork = [];
            foreach ($socials as $network => $link) {
                $profileNetwork[$network] = $link;
            }
            return $profileNetwork;
        } catch (\Exception $ex) {
            return [];
        }
    }

    public function getCv()
    {
        if ($this->cv_filename) {
            if (file_exists($this->getRelativePath('cv').DIRECTORY_SEPARATOR.$this->cv_filename)) {
                return $this->getRelativePath('cv').DIRECTORY_SEPARATOR.$this->cv_filename.'?'.Carbon::now()->timestamp;
            }
        }
    }

    public function getAvatar()
    {
        if (File::exists($this->getBasePathUpload('avatar'))) {
            $avatars = File::allFiles($this->getBasePathUpload('avatar'));
            $avatarArray = [];
            foreach ($avatars as $avatar) {
                array_push($avatarArray,
                    $this->getRelativePath('avatar').DIRECTORY_SEPARATOR.$avatar->getFilename().'?'.Carbon::now()->timestamp
                );
            }
            return $avatarArray;
        }
        return null;
    }

    private function getBasePathUpload($type)
    {
        return public_path($this->getRelativePath($type));
    }

    private function getRelativePath($type)
    {
        $user = Auth::user();
        return config('image.real_path') .DIRECTORY_SEPARATOR.getCustomerBaseDirectory($user->salt).$type;
    }
}
