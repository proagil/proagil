<?php

class Iteration extends Eloquent{

	public static function enumerate(){

		return DB::table('iteration')->where('enabled', TRUE)->get();
	}

	public static function deleteActivity($iterationId){
		try{
			
			return DB::table('iteration')->where('id', $iterationId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}
	}

	public static function insert($values){

		return DB::table('iteration')->insertGetId($values);
	}

	public static function get($iterationId){

		return DB::table('iteration')
				  	->where('id', $iterationId)
				  	->first();
	}	
	
}

?>
