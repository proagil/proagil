<?php

class Iteration extends Eloquent{

	public static function enumerate(){

		return DB::table('iteration')->where('enabled', TRUE)->get();
	}

	public static function getArtefactsByIteration($iterationId){

		return DB::table('artefact_belongs_to_project AS abtp')

				->select('a.*','f.server_name AS icon_file')

			  	->where('abtp.iteration_id', $iterationId)

				->leftJoin('artefact AS a', 'a.id', '=', 'abtp.artefact_id')

				->leftJoin('file AS f', 'f.id', '=', 'a.icon')
			  	
			  	->get();
	}

	
}

?>
