<?php

class StormIdeas extends Eloquent{

	public static function deleteStormIdeas($stormIdeasId){
		try{

			return DB::table('storm_ideas')
						->where('id', $stormIdeasId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}

	}

	public static function enumerate($projectId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('storm_ideas')->where('project_id', $projectId)->get();
	}

	public static function get($stormIdeasId){

		return DB::table('storm_ideas')->where('id', $stormIdeasId)
											 ->where('enabled', TRUE)
				  							 ->first();
	}

	public static function insert($values){

		return DB::table('storm_ideas')->insertGetId($values);
	}

	public static function insertStormIdeasWord($values){

		return DB::table('storm_ideas_word')->insertGetId($values);
	}

	public static function updateStormIdeas($id, $values){

		return DB::table('storm_ideas')->where('id', $id)->update($values);
	}

}

?>
