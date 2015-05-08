<?php

class Activity extends Eloquent{

	public static function enumerate(){

		return DB::table('activity')->where('enabled', TRUE)->get();
	}

	public static function deleteActivity($activityId){
		try{
			
			return DB::table('activity')->where('id', $activityId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}
	}

	public static function deleteComment($commentId){

		try{

			return DB::table('activity_comment')->where('id', $commentId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}	

	public static function deleteActivityComment($activityId){

		try{

			return DB::table('activity_comment')->where('activity_id', $activityId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}		

	public static function deleteIterationActivity($activityId, $iterationId){

		try{
			return DB::table('activity_belongs_to_project')
					->where('activity_id', $activityId)
					->where('iteration_id', $iterationId)
					->delete();
		}catch(\Exception $e){

			return false; 

		}		
	}

	public static function deleteProjectActivity($activityId, $projectId){

		try{
			return DB::table('activity_belongs_to_project')
					->where('activity_id', $activityId)
					->where('project_id', $projectId)
					->delete();
		}catch(\Exception $e){

			return false; 

		}		
	}	

	public static function get($activityId){

		return DB::table('activity AS a')

				->select('a.*', 'u.first_name', 'cabtp.name AS category_name', 'p.id AS project_id', 'p.name AS project_name', 'abtp.id AS abtp_id','abtp.iteration_id', 'abtp.user_id')

			  	->where('a.id', $activityId)

				->where('a.enabled', TRUE)

				->leftJoin('activity_belongs_to_project AS abtp', 'abtp.activity_id', '=', 'a.id')

				->leftJoin('project AS p', 'abtp.project_id', '=', 'p.id')

				->leftJoin('category_activity_belongs_to_project AS cabtp', 'cabtp.id', '=', 'a.category_id')

				->leftJoin('user AS u', 'abtp.user_id', '=', 'u.id')
			  	
			  	->first();
	}

	public static function getById($activityId){

		return DB::table('activity_belongs_to_project AS abtp')

				->select('a.*', 'abtp.id AS abtp_id','abtp.user_id', 'abtp.project_id', 'abtp.iteration_id' )

				->where('abtp.activity_id', $activityId)
								
				->join('activity AS a', 'a.id', '=', 'abtp.activity_id')

				->first();
	}

	public static function getComments($activityId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('activity_comment AS ac')

				->select('ac.*', 'f.server_name AS avatar_file', 'u.first_name AS user_first_name', 'u.avatar AS user_avatar')

				->where('ac.activity_id', $activityId)

				->leftJoin('user AS u', 'u.id', '=', 'ac.user_id')

				->leftJoin('file AS f', 'f.id', '=', 'u.avatar')

				->orderBy('ac.id', 'DESC')

				->get();
	}

	public static function getActivityUserAndProject($activityId){

		return DB::table('activity_belongs_to_project AS abtp')

				->select('abtp.*', 'abtp.id AS abtp_id','u.*', 'a.title' )

				->where('abtp.activity_id', $activityId)

				->join('user AS u', 'u.id', '=', 'abtp.user_id')

				->join('activity AS a', 'a.id', '=', 'abtp.activity_id')
								
				->first();
	}

	public static function getComment($commentId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('activity_comment AS ac')

				->select('ac.*', 'f.server_name AS avatar_file', 'u.first_name AS user_first_name', 'u.avatar AS user_avatar')

				->where('ac.id', $commentId)
				
				->leftJoin('user AS u', 'u.id', '=', 'ac.user_id')

				->leftJoin('file AS f', 'f.id', '=', 'u.avatar')


				->first();
	}

	public static function insert($values){

		return DB::table('activity')->insertGetId($values);
	}

	public static function insertProjectActivity($values){

		return DB::table('activity_belongs_to_project')->insertGetId($values);
	}

	public static function saveComment($values){

		return DB::table('activity_comment')->insertGetId($values);
	}	

	public static function updateActivity($activityId, $values){

		return DB::table('activity')->where('id', $activityId)->update($values);
	}

	public static function updateProjectActivity($abtpId, $values){

		return DB::table('activity_belongs_to_project')->where('id', $abtpId)->update($values);
	}	
	
}

?>
