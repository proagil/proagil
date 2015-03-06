<?php

class AdminArtefact extends Eloquent{

	public static function enumerate(){

		return DB::table('artefact')

				->select('artefact.*', 'file.server_name AS icon_file')

				->leftJoin('file', 'file.id', '=', 'artefact.icon')

				->orderBy('id', 'ASC')

				->get();
	}

	public static function get($entity_id){

		return DB::table('artefact')

				->select('artefact.*', 'file.server_name AS icon_file')

				->leftJoin('file', 'file.id', '=', 'artefact.icon')

				->where('artefact.id', $entity_id)

				->first();
	}	

	public static function insert($values){

		return DB::table('artefact')->insertGetId($values);

	}

	public static function edit($entity_id, $values){

		return DB::table('artefact')->where('id', $entity_id)->update($values);

	}

	public static function _delete($entity_id){

		try{

			return DB::table('artefact')->where('id', $entity_id)->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}

}

?>
