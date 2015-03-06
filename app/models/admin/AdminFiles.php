<?php

class AdminFiles extends Eloquent{

	public static function insert($values){

		return DB::table('file')->insertGetId($values);
	}

	public static function _update($id, $values){

		return DB::table('file')->where('id', $id)->update($values);
	}

}

?>
