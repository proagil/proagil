<?php
class Use_case extends Eloquent{


	public static function enumerate($iterationId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('use_diagram')->where('iteration_id', $iterationId)->orderby('use_diagram.id', 'DES')->get();
	}


	public static function insertUseCase($values){

		return DB::table('use_diagram')->insertGetId($values);
	}

	public static function deleteUseCase($usecaseId){

		try{

			return DB::table('use_diagram')
						->where('id', $usecaseId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}

	}

	public static function editUseCase($usecaseId, $values){

		return DB::table('use_diagram')->where('id', $usecaseId)->update($values);

	}


	public static function getName($use_caseid) {

		return DB::table('use_diagram')->where('id', $use_caseid)->first();

	}	

	public static function getUseCaseInfo($usecaseId){

		 // get probe data
		 return DB::table('use_diagram AS u')

		->select('u.*')

		->where('u.id', $usecaseId)

		->first();		

	}

	public static function getId($projectId){

		 // get probe data
		return DB::table('use_diagram')->where('id_project', $projectId)->first();		

	}



}

?>