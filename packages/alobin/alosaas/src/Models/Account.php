<?php

use Illuminate\Database\Eloquent\Model as Model;

class Account extends Model
{
	/**
	 * table name
	 */
	protected $table = "accounts";
	
	public function users()
	{
		return $this->hasMany("App/User");
	}
}