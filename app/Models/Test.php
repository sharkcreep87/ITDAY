<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Test extends Core  {
	
	protected $table = 'User_profile';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT User_profile.* FROM User_profile  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE User_profile.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function queryOrder(){
		return "  ORDER BY User_profile.id ASC ";
	}

}
