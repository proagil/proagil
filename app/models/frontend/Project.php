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

	public static function _delete($projectId){

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

	public static function getProjectIterations($userId, $projectId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$consult = DB::table('user_belongs_to_project AS ubtp')

				->select('i.*')

				->where('ubtp.user_id', $userId)

				->where('ubtp.project_id', $projectId)

				->leftJoin('iteration AS i', 'i.id', '=', 'ubtp.iteration_id')

				->orderBy('i.order')

				->get();

		foreach($consult as $row){
			$result[$row['id']] = $row; 
		}	

		return $result; 

	}	

	public static function getOwnerProjects($userId){

		DB::setFetchMode(PDO::FETCH_ASSOC);


		$ownerProjects = DB::table('user_belongs_to_project AS ubtp')

			->select('p.id', 'p.name')

			->where('ubtp.user_id', $userId)

			->where('ubtp.user_role_id', Config::get('constant.project.owner'))

			->join('project AS p', 'p.id', '=', 'ubtp.project_id')

			->groupBy('p.id')

			->orderBy('p.id', 'des')

			->get();

			// get project iteration
			foreach($ownerProjects as $index => $project){

				$iterationId = DB::table('user_belongs_to_project AS ubtp')
				->select('ubtp.iteration_id')
				->where('ubtp.project_id', $project['id'])
				->where('ubtp.user_id', $userId)
				->get();

				$ownerProjects[$index]['iteration_id'] = implode(min($iterationId));

			}

			return $ownerProjects; 


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

		$memberProjects =  DB::table('user_belongs_to_project AS ubtp')

			->select('p.id', 'p.name')

			->where('ubtp.user_id', $userId)

			->where('ubtp.user_role_id', Config::get('constant.project.member'))

			->join('project AS p', 'p.id', '=', 'ubtp.project_id')

			->groupBy('p.id')

			->orderBy('p.id', 'des')

			->get();

			// get project iteration
			foreach($memberProjects as $index => $project){

				$iterationId = DB::table('user_belongs_to_project AS ubtp')
				->select('ubtp.iteration_id')
				->where('ubtp.project_id', $project['id'])
				->where('ubtp.user_id', $userId)
				->first();

				$memberProjects[$index]['iteration_id'] = implode($iterationId);

			}

			return $memberProjects; 			

	}

	public static function getUsersOnIteration($iterationId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$result = DB::table('user_belongs_to_project AS ubtp')

			->select('u.id', 'u.first_name', 'u.email', 'ubtp.user_role_id', 'ubtp.iteration_id')

			->where('ubtp.iteration_id', $iterationId)

			->join('user AS u', 'ubtp.user_id', '=', 'u.id')

			->get();

		$usersOnIteration = array(); 
		
		foreach($result as $index => $row){
			$usersOnIteration[$row['id']] = $row['first_name'];
		}

		return $usersOnIteration; 

	}

	public static function getAllUsersOnIteration($iterationId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$result = DB::table('user_belongs_to_project AS ubtp')

			->select('u.id', 'u.first_name', 'u.email', 'ubtp.user_role_id', 'ubtp.iteration_id')

			->where('ubtp.iteration_id', $iterationId)

			->join('user AS u', 'ubtp.user_id', '=', 'u.id')

			->get();

		$usersOnIteration = array(); 
		
		foreach($result as $index => $row){
			$usersOnIteration[$row['id']] = $row['first_name'];
		}

		return $usersOnIteration; 

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

	public static function getIterationActivities($iterationId, $filtersArray=NULL, $statusArray=NULL) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$query =  DB::table('activity_belongs_to_project AS abtp')

			->select('u.id AS user_id', 'u.first_name', 'a.id AS activity_id', 'a.*', 'cabtp.name AS category_name')

			->where('abtp.iteration_id', $iterationId);

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

				  ->leftJoin('category_activity_belongs_to_project AS cabtp', 'cabtp.id', '=', 'a.category_id')

				  ->orderBy('a.id', 'DES');

			return $query->get();		

	}

	public static function getProjectActivities($projectId, $filtersArray=NULL, $statusArray=NULL) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$query =  DB::table('activity_belongs_to_project AS abtp')

			->select('u.id', 'u.first_name', 'a.*', 'cabtp.name AS category_name')

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

				  ->leftJoin('category_activity_belongs_to_project AS cabtp', 'cabtp.id', '=', 'a.category_id')

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
