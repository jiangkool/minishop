<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
		'nickname',
		'gender',
		'avatar',
		'phone',
		'weixin_openid',
		'weixin_session_key',
		'victory_total',
		'victory_current',
		'spend_total',
		'spend_current',
		'integral_total',
		'integral_current',
		'm_total',
		'm_current',
		'status',
		'session_id',
		'parent_id',
		'wechat',
		'areas',
		'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function coupons()
    {
    	return $this->belongsToMany(Coupon::class,'user_coupons','user_id','coupon_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

}
