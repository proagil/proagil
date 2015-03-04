<?php

class ActivityCategory extends Eloquent{


	public static function insert($values){

		return DB::table('category_activity_belongs_to_project')->insertGetId($values);
	}

	public static function edit($id, $values){

		return DB::table('category_activity_belongs_to_project')->where('id', $id)->update($values);
	}	

	public static function get($projectId){

		return DB::table('category_activity_belongs_to_project')
				  	->where('project_id', $projectId)
				  	->get();
	}

	public static function _delete($categoryId){

		try{

			return DB::table('category_activity_belongs_to_project')->where('id', $categoryId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}

}

?>
