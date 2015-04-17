<?php

class StyleGuide extends Eloquent{

	public static function enumerate($projectId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		return DB::table('style_guide')->where('project_id', $projectId)->get();
	}

	public static function insert($values){

		return DB::table('style_guide')->insertGetId($values);

	}

	public static function saveColor($values){

		return DB::table('style_guide_color')->insertGetId($values);

	}	

	public static function savefont($values){

		return DB::table('style_guide_font')->insertGetId($values);

	}

	public static function getSyleGuideData($styleGuideId) {

		DB::setFetchMode(PDO::FETCH_ASSOC);

		 // get existing system data
		 $styleGuide = DB::table('style_guide AS sg')

		->select('sg.*', 'f.server_name AS logo_image', 'f2.server_name AS interface_image')

		->where('sg.id', $styleGuideId)

		->leftJoin('file AS f', 'f.id', '=', 'sg.logo')

		->leftJoin('file AS f2', 'f2.id', '=', 'sg.interface')

		->first();

			// get style guide colors
			$styleGuideColors = DB::table('style_guide_color AS sgc')

			->select('sgc.*')

			->where('sgc.style_guide_id', $styleGuideId)

			->get();

			$styleGuide['colors'] = $styleGuideColors; 	


			// get style guide fonts
			$styleGuideFotns = DB::table('style_guide_font AS sgf')

			->select('sgf.*')

			->where('sgf.style_guide_id', $styleGuideId)

			->get();

			$styleGuide['fonts'] = $styleGuideFotns; 	


			return $styleGuide; 

	}

	public static function getStyleGuideByProject($projectId){

		DB::setFetchMode(PDO::FETCH_ASSOC);

		 // get existing system data
		 $styleGuides = DB::table('style_guide AS sg')

		->select('sg.*', 'f.server_name AS logo_image', 'f2.server_name AS interface_image')

		->where('sg.project_id', $projectId)

		->leftJoin('file AS f', 'f.id', '=', 'sg.logo')

		->leftJoin('file AS f2', 'f2.id', '=', 'sg.interface')

		->get();

		foreach($styleGuides as $index => $styleGuide){

			// get style guide colors
			$styleGuideColors = DB::table('style_guide_color AS sgc')

			->select('sgc.*')

			->where('sgc.style_guide_id', $styleGuide['id'])

			->get();

			$styleGuides[$index]['colors'] = $styleGuideColors; 	


			// get style guide fonts
			$styleGuideFotns = DB::table('style_guide_font AS sgf')

			->select('sgf.*')

			->where('sgf.style_guide_id', $styleGuide['id'])

			->get();

			$styleGuides[$index]['fonts'] = $styleGuideFotns; 				

		}
		
			return $styleGuides; 		

	}	

	public static function deleteColor($colorId) {

		try{

		$deletedElement = DB::table('style_guide_color AS sgc')
			 		->where('sgc.id', $colorId)
			 		->delete();			

		return $deletedElement;

		
		}catch(\Exception $e){

			return false; 

		}

	}

	public static function deleteFont($fontId) {

		try{

		$deletedElement = DB::table('style_guide_font AS sgf')
			 		->where('sgf.id', $fontId)
			 		->delete();

		return $deletedElement;

		
		}catch(\Exception $e){

			return false; 

		}

	}	

	public static function _update($styleGuideId, $styleGuide){

		return DB::table('style_guide')->where('id', $styleGuideId)->update($styleGuide);

	}

	public static function deletePrimaryColors($styleGuideId){

		try{

			return DB::table('style_guide_color AS sgc')
					->where('sgc.style_guide_id', $styleGuideId)
					->where('sgc.type', 1)
					->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}	

	public static function deleteSecundaryColors($styleGuideId){

		try{

			return DB::table('style_guide_color AS sgc')
					->where('sgc.style_guide_id', $styleGuideId)
					->where('sgc.type', 2)
					->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}		

	public static function deleteFonts($styleGuideId){

		try{

			return DB::table('style_guide_font AS sgf')
					->where('sgf.style_guide_id', $styleGuideId)
					->delete();
		
		}catch(\Exception $e){

			return false; 

		}

	}	

	public static function deleteStyleGuide($styleGuideId){

		try{

			$deletedColors = DB::table('style_guide_color AS sgc')
					->where('sgc.style_guide_id', $styleGuideId)
					->delete();

			$deletedFonts =  DB::table('style_guide_font AS sgf')
					->where('sgf.style_guide_id', $styleGuideId)
					->delete();		

			return DB::table('style_guide AS sg')
					->where('sg.id', $styleGuideId)
					->delete();

		
		}catch(\Exception $e){

			return false; 

		}		

	}


}

?>
