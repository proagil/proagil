<?php

class Activity extends Eloquent{

	public static function enumerate(){

		return DB::table('activity')->where('enabled', TRUE)->get();
	}

	public static function get($activityId){

		return DB::table('activity AS a')

				->select('a.*', 'u.first_name', 'cabtp.name AS category_name', 'p.id AS project_id', 'p.name AS project_name')

			  	->where('a.id', $activityId)

				->where('a.enabled', TRUE)

				->leftJoin('activity_belongs_to_project AS abtp', 'abtp.activity_id', '=', 'a.id')

				->leftJoin('project AS p', 'abtp.project_id', '=', 'p.id')

				->leftJoin('category_activity_belongs_to_project AS cabtp', 'cabtp.id', '=', 'a.category_id')

				->leftJoin('user AS u', 'abtp.user_id', '=', 'u.id')
			  	
			  	->first();
	}

	public static function saveComment($values){

		return DB::table('activity_comment')->insertGetId($values);
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

		public static function getComment($commentId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('activity_comment AS ac')

				->select('ac.*', 'f.server_name AS avatar_file', 'u.first_name AS user_first_name', 'u.avatar AS user_avatar')

				->where('ac.id', $commentId)
				
				->leftJoin('user AS u', 'u.id', '=', 'ac.user_id')

				->leftJoin('file AS f', 'f.id', '=', 'u.avatar')


				->first();
	}

	public static function deleteComment($commentId){

		try{

			return DB::table('activity_comment')->where('id', $commentId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}


}

?>
