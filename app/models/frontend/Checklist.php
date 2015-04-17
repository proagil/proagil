<?php

class Checklist extends Eloquent{

	public static function deleteChecklist($checklistId){
		try{

			return DB::table('comprobation_list')
						->where('id', $checklistId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}

	}

	public static function deleteChecklitsElement($elementId){
		try{

			$deletedItem =  DB::table('comprobation_list_item_belongs_to_comprobation_list')
						->where('comprobation_list_item_id', $elementId)
						->delete();

			return DB::table('comprobation_list_item')
						->where('id', $elementId)
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

	public static function deleteNewChecklistItem($checklistItemId){
		try{

			return DB::table('comprobation_list_item')
						->where('id', $checklistItemId)
						->delete();

		}catch(\Exception $e){

			return false; 

		}
	}	

	public static function enumerate($projectId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('comprobation_list')
				   ->where('project_id', $projectId)
				   ->orderBy('id', 'asc')
				   ->get();
	}

	public static function enumerateAllItemsByChecklistId($checklistId) {
		
		DB::setFetchMode(PDO::FETCH_ASSOC);
		return DB::table('comprobation_list_item_belongs_to_comprobation_list AS clibtcl')
				->select ('cli.*', 'clibtcl.status' )
				->where('clibtcl.comprobation_list_id', $checklistId)
				->join('comprobation_list_item AS cli', 'cli.id', '=', 'clibtcl.comprobation_list_item_id')
				->get();
	}

	public static function getChecklistsByProject($projectId){


		DB::setFetchMode(PDO::FETCH_ASSOC);

		$checklists = DB::table('comprobation_list')
		   ->where('project_id', $projectId)
		   ->orderBy('id', 'asc')
		   ->get();

		foreach($checklists as $index => $checklist){

			$checklistItem =  DB::table('comprobation_list_item_belongs_to_comprobation_list AS clibtcl')
					->select ('cli.*', 'clibtcl.status' )
					->where('clibtcl.comprobation_list_id', $checklist['id'])
					->join('comprobation_list_item AS cli', 'cli.id', '=', 'clibtcl.comprobation_list_item_id')
					->get();	

			$checklists[$index]['elements'] = $checklistItem;

		}

		return $checklists; 


	}

	public static function enumerateDefaultItems() {
		
		return DB::table('comprobation_list_item')->where('enabled', TRUE)
												  ->where('default', 1)
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

		DB::setFetchMode(PDO::FETCH_ASSOC);
		$consult = DB::table('comprobation_list_item_belongs_to_comprobation_list AS clibtcl')
											->select ('cli.id')
											->where('clibtcl.comprobation_list_id', $checklistId)
											->where('cli.default', 1)
											->join('comprobation_list_item AS cli', 'cli.id', '=', 'clibtcl.comprobation_list_item_id')
				  							->get();

		$result = array();


		foreach($consult as $index => $row){
			$result[$index] = $row['id']; 
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

	public static function updateChecklistItem($id, $values){

		return DB::table('comprobation_list_item_belongs_to_comprobation_list')->where('comprobation_list_item_id', $id)->update($values);
	}

}

?>
