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

	public static function getName($projectId) {

		return DB::table('project')->where('id', $projectId)->first();

	}	

	public static function get($projectId){

		return DB::table('project')
				  	->where('id', $projectId)
					->where('enabled', TRUE)
				  	->first();
	}

	public function _delete($projectId){

		try{

			return DB::table('project')->where('id', $projectId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}		
	
	}		

	public static function getProjectArtefacts($projectId, $mode=NULL){

		$consult = DB::table('artefact_belongs_to_project AS abtp')

				->select('a.*', 'f.server_name AS icon_file')

				->where('abtp.project_id', $projectId)

				->leftJoin('artefact AS a', 'a.id', '=', 'abtp.artefact_id')

				->leftJoin('file AS f', 'f.id', '=', 'a.icon')

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

	public static function userIsOwner($userId, $projectId){

		return DB::table('user_belongs_to_project AS ubtp')

			->select('p.id', 'p.name')

			->where('ubtp.user_id', $userId)

			->where('ubtp.project_id', $projectId)

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

	public static function getAllUsersOnProject($projectId){

		$result = DB::table('user_belongs_to_project AS ubtp')

			->select('u.id', 'u.first_name', 'u.email', 'ubtp.user_role_id')

			->where('ubtp.project_id', $projectId)

			->join('user AS u', 'ubtp.user_id', '=', 'u.id')

			->join('project AS p', 'p.id', '=', 'ubtp.project_id')

			->get();

		$usersOnProject = array(); 
		
		foreach($result as $index => $row){
			$usersOnProject[$row->id] = $row->first_name;
		}

		return $usersOnProject; 

	}


	public static function getUsersOnProject($projectId, $ownerId){

		return DB::table('user_belongs_to_project AS ubtp')

			->select('u.id', 'u.first_name', 'u.email', 'ubtp.user_role_id')

			->where('ubtp.project_id', $projectId)

			->join('user AS u', 'ubtp.user_id', '=', 'u.id')

			->join('project AS p', 'p.id', '=', 'ubtp.project_id')

			->whereNotIn('u.id', array($ownerId))

			->get();

	}

	public static function getActivitiesByProject($projectId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('activity_belongs_to_project AS abtp')

			->select('abtp.activity_id')

			->where('abtp.project_id', $projectId)

			->get(); 

	}

	public static function getProjectActivities($projectId, $filtersArray=NULL, $statusArray=NULL) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$query =  DB::table('activity_belongs_to_project AS abtp')

			->select('u.id', 'u.first_name', 'a.*')

			->where('abtp.project_id', $projectId);

			// filter by activity category
			if(!empty($filtersArray) && $filtersArray!=NULL){
				$query->whereIn('a.category_id', $filtersArray); 
			}

			// filter by  status
			if(!empty($statusArray) && $statusArray!=NULL){
				$query->whereIn('a.status', $statusArray); 
			}

			$query->join('user AS u', 'abtp.user_id', '=', 'u.id')

				  ->join('activity AS a', 'a.id', '=', 'abtp.activity_id')

				  ->orderBy('a.id', 'ASC');

			return $query->get();		

	}

	public static function updateActivity($activityId, $values) {

		return DB::table('activity')->where('id', $activityId)->update($values);
	}

	public static function deleteArtefacts($projectId){

		try{

			return DB::table('artefact_belongs_to_project')->where('project_id', $projectId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}		

	}

	public static function deleteCategoriesActivity($projectId){

		try{

			return DB::table('category_activity_belongs_to_project')->where('project_id', $projectId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}		

	}

	public static function deleteUsers($projectId){

		try{

			return DB::table('user_belongs_to_project')->where('project_id', $projectId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}		
	
	}	


}

?>
