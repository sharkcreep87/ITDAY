<?php namespace App\Models\Core;

use App\Models\Core;
use Illuminate\Database\Eloquent\Model;

class Menu extends Core {

	protected $table 		= 'tb_menu';
	protected $primaryKey 	= 'menu_id';

	public function __construct() {
		parent::__construct();				
	} 

}