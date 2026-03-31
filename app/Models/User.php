<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    protected $connection = 'pgsql';
    protected $table = 'users';

    use HasApiTokens, HasFactory, Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'name', 'email', 'role_id', 'password','picture','created_by','created_at','updated_at','updated_by','pps_no','default_password','hospital_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable=['name', 'email', 'password', 'role_id','password_confirmation', 'phone', 'location', 'old_password','picture'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

   /**
     * Check if the user has admin role
     */
    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    /**
     * Check if the user has creator role
     */
    public function isCreator()
    {
        return $this->role_id == 2;
    }

    /**
     * Check if the user has user role
     */
    public function isMember()
    {
        return $this->role_id == 3;
    }

    /**
     * Check if the user has cashier role
     */

    public function isCashier()
    {
        return $this->role_id == 4;
    }

    public function isHospital()
    {
        return $this->role_id == 5;
    }

    public function isAttendance()
    {
        return $this->role_id == 6;
    }

    public function role(){

        return $this->belongsTo(Role::class);
    }
}
