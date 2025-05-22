<?php

namespace Fickrr;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Fickrr\Models\Bid;
use Fickrr\Models\JobApplication;
use Fickrr\Models\UserType;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 
	const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'vendor';
    const CLIENT_TYPE = 'client';
	
	
	public function isAdmin()    {
		return $this->user_type === self::ADMIN_TYPE;
	}
	
	public function bids()
	{
		return $this->hasMany(Bid::class);
	}
	
	public function applications()
	{
		return $this->hasMany(JobApplication::class, 'freelancer_id');
	}
	
	public function getApplication($job)
	{
		return $this->applications()->where('job_id', $job->id)->first();
	}
	 
    public function isClient()    {
		return $this->user_type === self::CLIENT_TYPE;
	}
	
	 
    protected $fillable = [
        'name', 'email', 'password', 'username', 'user_token', 'earnings', 'user_type','provider', 'provider_id', 'verified', 'user_subscr_download_item',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jobs()
    {
        return $this->hasMany(\Fickrr\Models\Job::class, 'employer_id');
    }

    public function types()
    {
        return $this->hasMany(UserType::class);
    }
	
}
