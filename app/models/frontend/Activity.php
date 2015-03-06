<?php

class Activity extends Eloquent{

	public static function enumerate(){

		return DB::table('activity')->where('enabled', TRUE)->get();
	}

	// public static function insertProjectArtefact($artefact){

	// 	return DB::table('artefact_belongs_to_project')->insertGetId($artefact);

	// }

	// public static function deleteProjectArtefact($projectId){

	// 	return DB::table('artefact_belongs_to_project')->where('project_id', $projectId)->delete();

	// }

	// public static function updateProjectArtefact($projectId, $artefact){

	// 	return DB::table('artefact_belongs_to_project')->insertGetId($artefact);

	// }

}

?>
