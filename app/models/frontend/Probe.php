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

}

?>
