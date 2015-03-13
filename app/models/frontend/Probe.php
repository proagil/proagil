<?php

class Probe extends Eloquent{

	public static function getAnswerTypes(){

		$result =  DB::table('probe_answer_type')->where('enabled', TRUE)->get();

		$types = array(); 

		foreach($result as $index => $row){
			$types[$row->id] = $row->name;
		}
		return $types; 
	}

}

?>
