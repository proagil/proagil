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

	public static function enumerate($iteration_id) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('storm_ideas AS si')

				->select('si.*', 'f.server_name AS storm_ideas_image')

				->where('si.iteration_id', $iteration_id)

				->where('si.enabled', TRUE)

				->leftJoin('file AS f', 'f.id', '=', 'si.image')

				->orderBy('si.id', 'asc')

				->get();									   
	}


	public static function get($stormIdeasId){

		return DB::table('storm_ideas AS si')

				->select('si.*', 'f.server_name AS storm_ideas_image')

				->where('si.id', $stormIdeasId)

				->where('si.enabled', TRUE)

				->leftJoin('file AS f', 'f.id', '=', 'si.image')									   
				
				->first();
	}

	public static function insert($values){

		return DB::table('storm_ideas')->insertGetId($values);
	}

	public static function updateStormIdeas($id, $values){

		return DB::table('storm_ideas')->where('id', $id)->update($values);
	}

}

?>
