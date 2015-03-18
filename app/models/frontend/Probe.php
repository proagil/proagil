<?php

class Probe extends Eloquent{

	public static function enumerate($probeId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('probe')->get();
	}

	public static function getAnswerTypes(){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$result =  DB::table('probe_answer_type')->where('enabled', TRUE)->get();

		$types = array(); 

		foreach($result as $index => $row){
			$types[$row['id']] = $row['name'];
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

			->select('pte.*','pat.name as form_element_name')

			->where('pte.probe_id', $probeData['id'])

			->join('probe_answer_type AS pat', 'pte.form_element', '=', 'pat.id')

			->orderBy('pte.id', 'ASC')

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

	public static function getProbeElements($probeId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		 // get probe data
		 $probeData = DB::table('probe AS p')

		->select('p.*')

		->orWhere('p.id', $probeId)

		->first();

			// get probe form elements
			$probeElements = DB::table('probe_template_element AS pte')

			->select('pte.*','pat.name as form_element_name')

			->where('pte.probe_id', $probeData['id'])

			->join('probe_answer_type AS pat', 'pte.form_element', '=', 'pat.id')

			->orderBy('pte.id', 'ASC')

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

	public static function getElementData($elementId){

		return DB::table('probe_template_element AS pte')

		->select('pte.*','pat.name as form_element_name')

		->where('pte.id', $elementId)

		->join('probe_answer_type AS pat', 'pte.form_element', '=', 'pat.id')

		->first();		

	}

	public static function updateElement($id, $values){

		return DB::table('probe_template_element')->where('id', $id)->update($values);
	}		

}

?>
