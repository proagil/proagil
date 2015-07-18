<?php
class Prototype extends Eloquent{


	public static function enumerate($iterationId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('prototype')->where('iteration_id', $iterationId)->orderby('prototype.id', 'DES')->get();
	}


	public static function insertPrototype($values){

		return DB::table('prototype')->insertGetId($values);
	}

	public static function deletePrototype($prototypeId){

		try{

			return DB::table('prototype')
						->where('id', $prototypeId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}

	}

	public static function editPrototype($prototypeId, $values){

		return DB::table('prototype')->where('id', $prototypeId)->update($values);

	}


	public static function getName($prototypeId) {

		return DB::table('prototype')->where('id', $prototypeId)->first();

	}	

	public static function getPrototypeInfo($prototypeId){

		 
		 return DB::table('prototype AS u')

		->select('u.*')

		->where('u.id', $prototypeId)

		->first();		

	}

	public static function getId($projectId){

		 // get probe data
		return DB::table('prototype')->where('id_project', $projectId)->first();		

	}

	public static function updateTitle($prototypeId, $name){

		return DB::table('prototype')->where('id', $prototypeId)->update($value);

	}

}

?>