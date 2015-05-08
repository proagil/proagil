<?php

class Artefact extends Eloquent{

	public static function enumerate($mode=NULL){

		$consult =  DB::table('artefact')->where('enabled', TRUE)->get();

		$result = array();

		if($mode!=NULL){

			foreach($consult as $index => $row){
				$result[$index] = $row->id; 
			}			
		}

		return ($mode!=NULL)?$result:$consult; 
	}

	public static function getAll(){
		
		$consult =  DB::table('artefact')->where('enabled', TRUE)->get();

		$result = array();

		foreach($consult as $row){
			$result[$row['id']] = $row; 
		}	

		return $result; 
	}

	public static function getArtefactOutIteration($iterationId){

		$consult = DB::table('artefact AS a')
					->select('a.*')
			        
			        ->leftjoin('artefact_belongs_to_project AS abtp', function($leftjoin)
			        {
			            $leftjoin	->on('abtp.artefact_id','=','a.id')
			            			->on('abtp.iteration_id','=', 1)
			            			->whereNull('abtp.iteration_id');
			        })
			        
			        ->get();

		return $consult; 
	}


	public static function countArtefacts(){
		return DB::table('artefact')->where('enabled', TRUE)->count();
	}

	public static function insertProjectArtefact($artefact){

		return DB::table('artefact_belongs_to_project')->insertGetId($artefact);

	}

	public static function deleteProjectArtefact($artefactId, $projectId){

		return DB::table('artefact_belongs_to_project')
					->where('project_id', $projectId)
					->where('artefact_id', $artefactId)
					->delete();

	}

	public static function deleteIterationArtefact($artefactId, $iterationId){

		return DB::table('artefact_belongs_to_project')
					->where('iteration_id', $iterationId)
					->where('artefact_id', $artefactId)
					->delete();

	}	

	public static function updateProjectArtefact($projectId, $artefact){

		return DB::table('artefact_belongs_to_project')->insertGetId($artefact);

	}

	public static function getByFriendlyUrl($friendlyUrl){

		return DB::table('artefact')
				  	->where('friendly_url', $friendlyUrl)
					->where('enabled', TRUE)
				  	->first();
	}	

	public static function getById($artefactId){

		return DB::table('artefact')
				  	->where('id', $artefactId)
					->where('enabled', TRUE)
				  	->first();
	}


}

?>
