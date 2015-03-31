<?php

class Checklist extends Eloquent{

	public static function deleteNewChecklistItem($checklistItemId){
		try{

			return DB::table('comprobation_list_item')
						->where('id', $checklistItemId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}
	}

	public static function deleteChecklistItem($checklistId){
		try{

			return DB::table('comprobation_list_item_belongs_to_comprobation_list')
						->where('comprobation_list_id', $checklistId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}

	}

	public static function enumerate($projectId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('comprobation_list')->where('project_id', $projectId)->get();
	}

	public static function enumerateDefaultItems() {

		return DB::table('comprobation_list_item')->where('enabled', TRUE)
												  ->where('default', 1)
												  ->get();
	}

	public static function enumerateItems($projectId) {

		return DB::table('comprobation_list_item')->where('enabled', TRUE)
												  ->get();
	}
	
	public static function enumerateNewItems($checklistId){

		DB::setFetchMode(PDO::FETCH_ASSOC);
		return DB::table('comprobation_list_item_belongs_to_comprobation_list AS clibtcl')
											->select ('cli.*')
											->where('clibtcl.comprobation_list_id', $checklistId)
											->where('cli.default', 2)
											->join('comprobation_list_item AS cli', 'cli.id', '=', 'clibtcl.comprobation_list_item_id')
				  							->get();
	}

	public static function enumerateOldItems($checklistId){

		$consult = DB::table('comprobation_list_item_belongs_to_comprobation_list AS clibtcl')
											->select ('cli.id')
											->where('clibtcl.comprobation_list_id', $checklistId)
											->where('cli.default', 1)
											->join('comprobation_list_item AS cli', 'cli.id', '=', 'clibtcl.comprobation_list_item_id')
				  							->get();

		$result = array();

		foreach($consult as $index => $row){
			$result[$index] = $row->id; 
		}

		return $result;
	}

	public static function get($checklistId){

		return DB::table('comprobation_list')->where('id', $checklistId)
											 ->where('enabled', TRUE)
				  							 ->first();
	}

	public static function insert($values){

		return DB::table('comprobation_list')->insertGetId($values);
	}

	public static function insertItems($values){

		return DB::table('comprobation_list_item')->insertGetId($values);
	}

	public static function insertChecklistItem($values){

		return DB::table('comprobation_list_item_belongs_to_comprobation_list')->insertGetId($values);

	}

	public static function updateChecklist($id, $values){

		return DB::table('comprobation_list')->where('id', $id)->update($values);
	}

}

?>