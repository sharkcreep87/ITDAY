<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Core  {
	
	protected $table = 'affiliateuser';
	protected $primaryKey = 'Id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT affiliateuser.* FROM affiliateuser  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE affiliateuser.Id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function queryOrder(){
		return "  ORDER BY affiliateuser.Id ASC ";
	}

}
