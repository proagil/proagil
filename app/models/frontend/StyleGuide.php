<?php

class StyleGuide extends Eloquent{

	public static function enumerate($projectId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('style_guide')->where('project_id', $projectId)->get();
	}

	public static function insert($values){

		return DB::table('style_guide')->insertGetId($values);

	}

	public static function saveColor($values){

		return DB::table('style_guide_color')->insertGetId($values);

	}	

	public static function savefont($values){

		return DB::table('style_guide_font')->insertGetId($values);

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
