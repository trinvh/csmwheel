<?php namespace App;

use Hash;
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
	protected $table = 'usertb';

	protected $primaryKey = 'UserId';

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
	protected $hidden = ['FirstName', 'LastName','MiddleName','UserName','Password','ID','Address','Phone','Email','City','State','Zipcode','Debit','CreditLimit','Active','RecordDate'];

	public function getRememberToken()
	{
		return null; // not supported
	}

	public function setRememberToken($value)
	{
		// not supported
	}

	public function getRememberTokenName()
	{
		return null; // not supported
	}

	public function getDisplayNameAttribute() {
		return ($this->MiddleName !== '') ? $this->MiddleName : ($this->FirstName !== '' ? $this->FirstName : $this->UserName);
	}

}
