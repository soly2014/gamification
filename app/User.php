<?php

namespace Learncloud;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
                'name',
                'email',
                'password',
                'type',
                'phone',
                'photo',
                'invited_by',
                'referral_code',
                'facebook_id',
                'shared_photo',
                'tweeted',
                'shared',
                'image_name',
                'twitter_id',
                'handle',
                'country',
                


      ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /////////////////////////////////////////////////////////

    public function userPoint()
    {
        return $this->belongsTo('Learncloud\Points','id','user_id');
    } 

    public function userRefunded()
    {
        return $this->belongsTo('Learncloud\Paycloud','id','user_id');
    }
}
