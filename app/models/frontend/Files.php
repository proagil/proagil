<?php

class Files extends Eloquent{

	public static function insert($values){

		return DB::table('file')->insertGetId($values);
	}

	public static function _update($id, $values){

		return DB::table('file')->where('id', $id)->update($values);
	}

	public static function _delete($fileId) {

		try{

		return DB::table('file AS f')
			 		->where('f.id', $fileId)
			 		->delete();

		}catch(\Exception $e) {

			return false; 

		}

	}		

}

?>
