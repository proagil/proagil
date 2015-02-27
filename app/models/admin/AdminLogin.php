<?php

class AdminLogin extends Eloquent{

	public static function enumerate(){

		return DB::table('admin_user')->orderBy('id', 'ASC')->get();
	}

	public static function getUserByEmail($email){

		return DB::table('admin_user')->where('email', $email)->first();
	}	

	public static function insert($values){

		return DB::table('admin_user')->insertGetId($values);

	}

	public static function edit($entity_id, $values){

		return DB::table('admin_user')->where('id', $entity_id)->update($values);

	}

	public static function _delete($entity_id){

		DB::table('admin_user')->where('id', $entity_id)->delete();

	}

}

?>
