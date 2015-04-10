<?php

class HeuristicEvaluation extends Eloquent{

	public static function enumerate($projectId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('heuristic_evaluation')->where('project_id', $projectId)->get();
	}

	public static function getHeuristics(){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$result =  DB::table('heuristic')->where('enabled', TRUE)->orderBy('id', 'ASC')->get();

		$heuristics = array(); 

		foreach($result as $index => $row){
			$heuristics[$row['id']] = $row['name'];
		}
		return $heuristics; 
	}

	public static function getValorations(){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		$result =  DB::table('heuristic_valoration')->where('enabled', TRUE)->orderBy('value', 'ASC')->get();

		$valorations = array(); 

		foreach($result as $index => $row){
			$valorations[$row['id']] = $row['name'];
		}
		return $valorations; 
	}	

	public static function insert($values){

		return DB::table('heuristic_evaluation')->insertGetId($values);
	}

	public static function edit($evaluationId, $values){

		return DB::table('heuristic_evaluation')->where('id', $evaluationId)->update($values);
	}	

	public static function saveProblem($values){

		return DB::table('heuristic_evaluation_item')->insertGetId($values);
	}

	public static function getEvaluationData($evaluationId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		 // get existing system data
		 $evaluationData = DB::table('heuristic_evaluation AS he')

		->select('he.*')

		->where('he.id', $evaluationId)

		->first();

			// get existing system form elements
			$evaluationElements = DB::table('heuristic_evaluation_item AS hei')

			->select('hei.*', 'h.name AS heuristic_name', 'hv.name AS valoration_name')

			->where('hei.heuristic_evaluation_id', $evaluationData['id'])

			->join('heuristic AS h', 'hei.heuristic_id', '=', 'h.id')

			->join('heuristic_valoration AS hv', 'hei.valoration_id', '=', 'hv.id')

			->orderBy('hei.id', 'ASC')

			->get();

			$evaluationData['elements'] = $evaluationElements; 	

			return $evaluationData; 

	}	

	public static function getElementData($elementId){

		return DB::table('heuristic_evaluation_item AS hei')

		->select('hei.*', 'hv.value AS valoration_value', 'h.name AS heuristic_name', 'hv.name AS valoration_name')

		->where('hei.id', $elementId)

		->join('heuristic AS h', 'hei.heuristic_id', '=', 'h.id')

		->join('heuristic_valoration AS hv', 'hei.valoration_id', '=', 'hv.id')

		->first();		

	}	

	public static function updateElement($id, $values){

		return DB::table('heuristic_evaluation_item')->where('id', $id)->update($values);
	}

	public static function deleteElement($elementId) {

		try{

		$deletedElement = DB::table('heuristic_evaluation_item AS hei')
			 		->where('hei.id', $elementId)
			 		->delete();			

		return $deletedElement;

		
		}catch(\Exception $e){

			return false; 

		}

	}

	public static function _delete($evaluetionId) {

		try{

		return DB::table('heuristic_evaluation AS he')
			 		->where('he.id', $evaluetionId)
			 		->delete();

		}catch(\Exception $e) {

			return false; 

		}

	}						


	

}

?>
