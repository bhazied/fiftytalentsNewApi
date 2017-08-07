<?php

namespace App\Model;

use App\Presenters\CandidateProfilePresenter;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class CandidateProfile extends Model
{
    use PresentableTrait;

    protected $presenter = CandidateProfilePresenter::class;

    protected $table = 'c_profiles';

    protected $guarded = ['id'];

    protected $casts = [
        'skills' => 'array',
        'skills_levels' => 'array',
        'states' => 'array',
        'favorite_skills' => 'array',
        'mobility_by_state' => 'array',
        'banned_enterprises' => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'disponibility_date'
    ];

    public function educations()
    {
        return $this->hasMany(Education::class, 'c_profile_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'c_profile_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(EntrepriseProfile::class, 'favorite_candidates', 'c_profile_id', 'e_profile_id');
    }
}
