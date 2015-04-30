<?php

class User extends Eloquent{

	public static function insert($values){

		return DB::table('user')->insertGetId($values);
	}

	public static function _update($id, $values){

		return DB::table('user')->where('id', $id)->update($values);
	}

	public static function enumerate(){

		return DB::table('user')->where('enabled', TRUE)->get();
	}

	public static function getUserById($userId){

		return DB::table('user')

				->select('user.*', 'file.server_name AS avatar_file')

				->where('user.id', $userId)

				->leftJoin('file', 'file.id', '=', 'user.avatar')

				->first();

	}	

	public static function getUserByEmail($email){

		return DB::table('user')

				->select('user.*', 'file.server_name AS avatar_file')

				->where('user.email', $email)

				->leftJoin('file', 'file.id', '=', 'user.avatar')

				->first();

	}

	public static function getUserByToken($token){

		return DB::table('user')->where('token', $token)->first();
	}	

	public static function userBelongsToProject($values){
		
		return DB::table('user_belongs_to_project')->insertGetId($values);
	}

	public static function EditUserBelongsToProject($userId, $projectId, $values){
		
		return DB::table('user_belongs_to_project')
					->where('user_id', $userId)
					->where('project_id', $projectId)
					->update($values);
	}

	public static function deleteUserOnProject($userId, $projectId){

		try{

			return DB::table('user_belongs_to_project')
					->where('user_id', $userId)
					->where('project_id', $projectId)
					->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}	

	public static function getRoles(){

		$result =  DB::table('user_role')->where('enabled', TRUE)->get();

		$roles = array(); 

		foreach($result as $index => $row){
			$roles[$row->id] = $row->name;
		}
		return $roles; 
	}

	public static function getUsersByProjectId($projectId){
		return DB::table('user_belongs_to_project')
					->where('project_id', $projectId)
					->where('user_role_id',2)
					->get;
	}	

	public static function getUserRoleOnProject($projectId, $userId){
		return DB::table('user_belongs_to_project')
					->where('project_id', $projectId)
					->where('user_id', $userId)
					->first();
	}

	public static function getUserRoleOnIteration($iterationId, $userId){
		return DB::table('user_belongs_to_project')
					->where('iteration_id', $iterationId)
					->where('user_id', $userId)
					->first();
	}

	public static function exist($email){

		$result =  DB::table('user')->where('email', $email)->first();

		return (empty($result))?FALSE:TRUE; 
	}

	public static function saveInvitation($values) {

		return DB::table('user_invitation')->insertGetId($values);

	}

	public static function getInvitationByToken($token){

		return DB::table('user_invitation')->where('token', $token)->first();

	}

	public static function updateInvitation($id, $values){

		return DB::table('user_invitation')->where('id', $id)->update($values);
	}

}

?>
