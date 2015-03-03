<?php

class Project extends Eloquent{

	public static function selectProjectTypes(){

		$result = DB::table('project_type')->where('enabled', TRUE)->get();

		$projectTypes = array(); 
		foreach($result as $index => $row){
			$projectTypes[$row->id] = $row->name;
		}

		return $projectTypes; 
	}

	public static function insert($values){

		return DB::table('project')->insertGetId($values);
	}

	public static function edit($projectId, $values){

		return DB::table('project')->where('id', $projectId)->update($values);
	}	

	public static function get($projectId){

		return DB::table('project')
				  	->where('id', $projectId)
					->where('enabled', TRUE)
				  	->first();
	}

	public static function getProjectArtefacts($projectId, $mode=NULL){

		$consult = DB::table('artefact_belongs_to_project AS abtp')

				->select('a.*')

				->where('abtp.project_id', $projectId)

				->leftJoin('artefact AS a', 'a.id', '=', 'abtp.artefact_id')

				->get();

		$result = array();

		if($mode==NULL){

			foreach($consult as $index => $row){
				$result[$index] = $row->id; 
			}			
		}

		return ($mode==NULL)?$result:$consult; 

	}

	public static function getOwnerProjects($userId){

		return DB::table('user_belongs_to_project AS ubtp')

			->select('p.id', 'p.name')

			->where('ubtp.user_id', $userId)

			->where('ubtp.user_role_id', Config::get('constant.project.owner'))

			->join('project AS p', 'p.id', '=', 'ubtp.project_id')

			->get();


	}

	public static function getMemberProjects($userId) {

		return DB::table('user_belongs_to_project AS ubtp')

			->select('p.id', 'p.name')

			->where('ubtp.user_id', $userId)

			->where('ubtp.user_role_id', Config::get('constant.project.member'))

			->join('project AS p', 'p.id', '=', 'ubtp.project_id')

			->get();

	}


}

?>
