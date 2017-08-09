<?php namespace App\Models\Core;

use App\Models\Core;
use Illuminate\Database\Eloquent\Model;

class Module extends Core {

	protected $table 		= 'tb_module';
	protected $primaryKey 	= 'module_id';

	public function __construct() {
		parent::__construct();		
	} 

}