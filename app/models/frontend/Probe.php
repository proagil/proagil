<?php

class Probe extends Eloquent{

	public static function enumerate($probeId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('probe')->get();
	}

	public static function getAnswerTypes(){

		$result =  DB::table('probe_answer_type')->where('enabled', TRUE)->get();

		$types = array(); 

		foreach($result as $index => $row){
			$types[$row->id] = $row->name;
		}
		return $types; 
	}

	public static function insert($values){

		return DB::table('probe')->insertGetId($values);
	}

	public static function saveQuestion($values){

		return DB::table('probe_template_element')->insertGetId($values);
	}

	public static function saveQuestionOption($values){

		return DB::table('probe_template_option')->insertGetId($values);
	}

	public static function getProbeTemplate($probeUrl){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		 // get probe data
		 $probeData = DB::table('probe AS p')

		->select('p.*')

		->where('p.url', $probeUrl)

		->first();

			// get probe form elements
			$probeElements = DB::table('probe_template_element AS pte')

			->select('pte.*')

			->where('pte.probe_id', $probeData['id'])

			->get();

			foreach($probeElements as $index => $probeElement){

				$probeOptions = DB::table('probe_template_option AS pto')

				->select('pto.*')

				->where('pto.probe_template_element_id', $probeElement['id'])

				->get();

				$probeElements[$index]['options'] = $probeOptions; 

			}

			$probeData['elements'] = $probeElements; 


		return $probeData;

	}		

}

?>
