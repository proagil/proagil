<?php

class Iteration extends Eloquent{

	public static function enumerate(){

		return DB::table('iteration')->where('enabled', TRUE)->get();
	}

	public static function getArtefactsByIteration($iterationId, $mode=NULL){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$consult = DB::table('artefact_belongs_to_project AS abtp')

				->select('a.*','f.server_name AS icon_file')

			  	->where('abtp.iteration_id', $iterationId)

				->leftJoin('artefact AS a', 'a.id', '=', 'abtp.artefact_id')

				->leftJoin('file AS f', 'f.id', '=', 'a.icon')
			  	
			  	->get();
			  	
		$result = array();

		if($mode==NULL){

			foreach($consult as $index => $row){
				$result[$row['id']] = $row; 
			}			
		}

		return ($mode==NULL)?$result:$consult; 


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

	public static function _update($id, $values){

		return DB::table('iteration')->where('id', $id)->update($values);
	}	

	public static function get($iterationId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('iteration')
				  	->where('id', $iterationId)
				  	->first();
	}	

	public static function getColaboratorOnIteration($iterationId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('user_belongs_to_project AS ubtp')
					->select('u.*')
				  	->where('ubtp.iteration_id', $iterationId)
				  	->leftJoin('user AS u', 'ubtp.user_id', '=', 'u.id')
				  	->get();
	}		

	public static function getIterationsByProject($projectId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('iteration')
				  	->where('project_id', $projectId)
				  	->orderBy('order')
				  	->get();
	}	

	public static function userIsOwner($userId, $iterationId){

		return DB::table('user_belongs_to_project AS ubtp')

			->select('i.id', 'i.name')

			->where('ubtp.user_id', $userId)

			->where('ubtp.iteration_id', $iterationId)

			->where('ubtp.user_role_id', Config::get('constant.project.owner'))

			->join('iteration AS i', 'i.id', '=', 'ubtp.iteration_id')

			->get();

	}

	public static function deleteIterationInvitations($iterationId){

		try{

			return DB::table('user_invitation')->where('iteration_id', $iterationId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}		
	
	}			

	public static function deleteUsers($iterationId){

		try{

			return DB::table('user_belongs_to_project')->where('iteration_id', $iterationId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}		
	
	}		

	public static function _delete($iterationId){

		try{

			return DB::table('iteration')->where('id', $iterationId)->delete();
		
		}catch(\Exception $e){

			return false; 

		}		
	
	}				
	
}

?>
