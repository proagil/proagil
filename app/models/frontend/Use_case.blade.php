<?php
class Use_case extends Eloquent{

	public static function insert($values){

		return DB::table('use_case_model')->insertGetId($values);
	}

	public static function delete($values){

		//id del elemento a eliminar, hacer lo en casacda por la tabla file (referencia a la imagen), tabla use_case_elemente
		/*try{

			return DB::table('artefact')->where('id', $entity_id)->delete();
		
		}catch(\Exception $e){

			return false; 

		}*/
	}

	public static function edit($values){

		return DB::table('use_case_element')->where('id', $entity_id)->update($values);

	}
?>