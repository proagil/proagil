<?php

class Iteration extends Eloquent{

	public static function enumerate(){

		return DB::table('iteration')->where('enabled', TRUE)->get();
	}

	public static function getArtefactsByIteration($iterationId){

		$consult = DB::table('artefact_belongs_to_project AS abtp')

				->select('a.*','f.server_name AS icon_file')

			  	->where('abtp.iteration_id', $iterationId)

				->leftJoin('artefact AS a', 'a.id', '=', 'abtp.artefact_id')

				->leftJoin('file AS f', 'f.id', '=', 'a.icon')
			  	
			  	->get();
			  	
		if (!empty($consult)){
			foreach($consult as $row){
				$result[$row['id']] = $row; 
			}	
			return $result;
		}else{
			return $consult;
		} 	

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
