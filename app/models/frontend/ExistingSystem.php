<?php

class ExistingSystem extends Eloquent{

	public static function enumerate($projectId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('existing_system')->where('project_id', $projectId)->get();
	}

	public static function getExistingSystemTopics(){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$result =  DB::table('existing_system_topic')->where('enabled', TRUE)->get();

		$types = array(); 

		foreach($result as $index => $row){
			$types[$row['id']] = $row['name'];
		}
		return $types; 
	}

	public static function insert($values){

		return DB::table('existing_system')->insertGetId($values);
	}

	public static function saveObservation($values){

		return DB::table('existing_system_topic_belogns_to_existing_system')->insertGetId($values);
	}

	public static function getExistingSystemData($systemId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		 // get existing system data
		 $existingSystem = DB::table('existing_system AS es')

		->select('es.*', 'f.server_name AS interface_image')

		->where('es.id', $systemId)

		->leftJoin('file AS f', 'f.id', '=', 'es.interface')

		->first();

			// get existing system form elements
			$existingSystemElements = DB::table('existing_system_topic_belogns_to_existing_system AS estbtes')

			->select('estbtes.*', 'est.name AS topic_name')

			->where('estbtes.existing_system_id', $existingSystem['id'])

			->join('existing_system_topic AS est', 'estbtes.existing_system_topic_id', '=', 'est.id')

			->orderBy('estbtes.id', 'DESC')

			->get();

			$existingSystem['elements'] = $existingSystemElements; 	

			return $existingSystem; 

	}	

	public static function getElementData($elementId){

		return DB::table('existing_system_topic_belogns_to_existing_system AS estbtes')

		->select('estbtes.*','est.name as topic_name')

		->where('estbtes.id', $elementId)

		->join('existing_system_topic AS est', 'estbtes.existing_system_topic_id', '=', 'est.id')

		->first();		

	}	

	public static function updateElement($id, $values){

		return DB::table('existing_system_topic_belogns_to_existing_system')->where('id', $id)->update($values);
	}

	public static function deleteElement($elementId) {

		try{

		$deletedElement = DB::table('existing_system_topic_belogns_to_existing_system AS estbtes')
			 		->where('estbtes.id', $elementId)
			 		->delete();			

		return $deletedElement;

		
		}catch(\Exception $e){

			return false; 

		}

	}


	public static function _delete($existingSystemId) {

		try{

		return DB::table('existing_system AS es')
			 		->where('es.id', $existingSystemId)
			 		->delete();

		}catch(\Exception $e) {

			return false; 

		}

	}						


	

}

?>
