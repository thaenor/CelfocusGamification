<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function league() {  return $this->belongsTo('League');    }

    public function reward() {  return $this->hasMany('Reward');      }

    public function article(){  return $this->hasMany('Article');     }

    public function groups()  {  return $this->belongsToMany('App\Group'); }


    public function updateUser($pts){
        if($pts >0){
            $this->points += $pts;
            if($pts > 5){
                $this->experience += 10;
            } else{
                $this->experience +=5;
            }
            $this->checkLvlUp();
        } else {
            $this->takeDamage($pts);
            $this->checkDeath();
        }
        $this->save();
    }

    public function checkLvlUp()
    {
        $articleUpdater = new Article();
        if($this->experience > 100){
            $this->level++;
            $this->save();
            //$articleUpdater->postAutomatedMessageLevelUp($this->id,$this->level);
        }
    }

    public function takeDamage($damage){
        $this->health_points -= $damage;
    }
    
    public function checkDeath()
    {
        $articleUpdater = new Article();
        if($this->health_points < 0){
            $this->level -= 1;
            $this->experience = 0;
            $this->points -= 50;
            $this->health_points = 100;
            $this->save();
            //$articleUpdater->postAutomatedMessageDead($this->full_name);
        }
    }
}
