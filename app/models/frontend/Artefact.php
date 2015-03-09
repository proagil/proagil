<?php

class Artefact extends Eloquent{

	public static function enumerate(){

		return DB::table('artefact')->where('enabled', TRUE)->get();
	}

	public static function insertProjectArtefact($artefact){

		return DB::table('artefact_belongs_to_project')->insertGetId($artefact);

	}

	public static function deleteProjectArtefact($projectId){

		return DB::table('artefact_belongs_to_project')->where('project_id', $projectId)->delete();

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
