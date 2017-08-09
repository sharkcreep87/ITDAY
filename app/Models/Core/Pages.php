<?php namespace App\Models\Core;

use App\Models\Core;
use Illuminate\Database\Eloquent\Model;

class Pages extends Core  {
	
	protected $table = 'tb_pages';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_pages.* FROM tb_pages  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_pages.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function queryOrder(){
		return "      ";
	}
	

}
