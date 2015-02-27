<?php

class AdminProjectType extends Eloquent{

	public static function enumerate(){

		return DB::table('project_type')->orderBy('id', 'ASC')->get();
	}

	public static function get($entity_id){

		return DB::table('project_type')->where('id', $entity_id)->first();
	}	

	public static function insert($values){

		return DB::table('project_type')->insertGetId($values);

	}

	public static function edit($entity_id, $values){

		return DB::table('project_type')->where('id', $entity_id)->update($values);

	}

	public static function _delete($entity_id){

		try{

			return DB::table('project_type')->where('id', $entity_id)->delete();
		
		}catch(\Exception $e){

			return false; 

		}

		

	}

}

?>
