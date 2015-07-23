<?php
class Object extends Eloquent{


	public static function enumerate($iterationId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('object_diagram')->where('iteration_id', $iterationId)->orderby('object_diagram.id', 'DES')->get();
	}


	public static function insertObject($values){

		return DB::table('object_diagram')->insertGetId($values);
	}

	public static function deleteObject($objectId){

		try{

			return DB::table('object_diagram')
						->where('id', $objectId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}

	}

	public static function editObject($objectId, $values){

		return DB::table('object_diagram')->where('id', $objectId)->update($values);

	}


	public static function getName($objectId) {

		return DB::table('object_diagram')->where('id', $objectId)->first();

	}	

	public static function getObjectInfo($objectId){

		 // get probe data
		 return DB::table('object_diagram AS u')

		->select('u.*')

		->where('u.id', $objectId)

		->first();		

	}

	public static function getId($projectId){

		 // get probe data
		return DB::table('object_diagram')->where('id_project', $projectId)->first();		

	}


	public static function updateTitle($projectId, $name){

		return DB::table('object_diagram')->where('id', $projectId)->update($value);

	}

}

?>