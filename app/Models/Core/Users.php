<?php namespace App\Models\Core;

use App\Models\Core;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Users extends Core  {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function __construct() {
		parent::__construct();
		
	}
	public static function querySelect(  ){
		
		return " SELECT  tb_users.*,  tb_groups.name 
		FROM tb_users LEFT JOIN tb_groups ON tb_groups.group_id = tb_users.group_id ";
	}	

	public static function queryWhere(  ){
		
		return "    WHERE tb_users.id !=''   ";
	}
	
	public static function queryGroup(){
		return "      ";
	}

	public static function queryOrder(){
		return "      ";
	}
	

}
