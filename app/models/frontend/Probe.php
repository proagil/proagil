<?php

class Probe extends Eloquent{

	public static function enumerate($projectId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('probe')->where('project_id', $projectId)->get();
	}

	public static function getAnswerTypes($type){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$result =  DB::table('probe_answer_type')->where('enabled', TRUE)->whereIn('type', $type)->get();

		$types = array(); 

		foreach($result as $index => $row){
			$types[$row['id']] = $row['name'];
		}
		return $types; 
	}

	public static function insert($values){

		return DB::table('probe')->insertGetId($values);
	}

	public static function _update($id, $values){

		return DB::table('probe')->where('id', $id)->update($values);
	}

	public static function _delete($probeId) {

		try{

		return DB::table('probe AS p')
			 		->where('p.id', $probeId)
			 		->delete();

		}catch(\Exception $e) {

			return false; 

		}

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

	public static function getProbeInfo($probeId){

		 // get probe data
		 return DB::table('probe AS p')

		->select('p.*')

		->where('p.id', $probeId)

		->first();		


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

	public static function getOptionData($optionId){

		return DB::table('probe_template_option AS pto')

		->select('pto.*')

		->where('pto.id', $optionId)

		->first();		

	}	

	public static function updateElement($id, $values){

		return DB::table('probe_template_element')->where('id', $id)->update($values);
	}	

	public static function updateOption($id, $values){

		return DB::table('probe_template_option')->where('id', $id)->update($values);
	}	

	public static function deleteQuestion($elementId) {

		try{

		$deletedResponses = DB::table('probe_template_element_value AS ptev')
			 		->where('ptev.probe_template_element_id', $elementId)
			 		->delete();			

		$deletedOptions = DB::table('probe_template_option AS pto')
			 					->where('pto.probe_template_element_id', $elementId)
			 					->delete();

		$deletedQuestion = DB::table('probe_template_element')
							 	->where('id', $elementId)
								->delete();

		return $deletedQuestion;

		
		}catch(\Exception $e){

			return false; 

		}

	}	

	public static function deleteOption($optionId) {

		try{

		$options = DB::table('probe_template_element_value AS ptev')
			 		->where('ptev.probe_template_option_id', $optionId)
			 		->delete();	

		return DB::table('probe_template_option AS pto')
			 		->where('pto.id', $optionId)
			 		->delete();

		}catch(\Exception $e) {

			return false; 

		}

	}

	public static function deleteProbeResponse($elementId) {

		try{

		return DB::table('probe_template_element_value AS ptev')
			 		->where('ptev.probe_template_element_id', $elementId)
			 		->delete();

		}catch(\Exception $e) {

			return false; 

		}

	}			

	public static function saveResponse($values) {

		return DB::table('probe_template_element_value')->insertGetId($values);

	} 				

}

?>
