<?php

class ActivityController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function detail($projectId, $activityId){

		// get user on session
        $user = Session::get('user');

        // get activity data
		$activity = (array) Activity::get($activityId); 
		$activity['date'] = date('d/m/Y', strtotime($activity['date']));

		switch($activity['status']){
			case 1:
				$activity['status_name'] = 'SIN EMPEZAR';
				break; 
			case 2:
				$activity['status_name'] = 'EN PROCESO';
				break; 			
			case 3:
				$activity['status_name'] = 'TERMINADA';
				break; 			
		}

		// get activity comments
		$comments = Activity::getComments($activityId); 

		//print_r($activity); die; 

		//format comments date and add flag to know comment autor
		foreach($comments as $index => $comment){
			$comments[$index]['date'] = date('d/m/Y', strtotime($comments[$index]['date']));

			($user['id']==$comment['user_id'])?$comments[$index]['editable'] = TRUE:$comments[$index]['editable'] = FALSE; 
		}

		return View::make('frontend.activity.detail')
					->with('activity', $activity)
					->with('comments', $comments); 

	}

	public function commnet() {

		// get user on session
        $user = Session::get('user');

		 $values = Input::get('values');

		 $comment = array(
		 	'comment'		=> $values['comment'],
		 	'date'			=> date('Y-m-d'),
		 	'user_id'		=> $user['id'],
		 	'activity_id'	=> $values['activity_id']
		 );

		 $commentId = Activity::saveComment($comment);

		 if($commentId>0){

		 	$insertedComment = Activity::getComment($commentId); 

		 	$insertedComment['date'] = date('d/m/Y', strtotime($insertedComment['date']));

			($user['id']==$insertedComment['user_id'])?$insertedComment['editable'] = true:$insertedComment['editable'] = false;

			 $result = array(
			 	'error'			=> false,
			 	'comment'		=> $insertedComment,
			 	'user'			=> $user
			 ); 

		 }else{

			 $result = array(
			 	'error'			=> true
			 ); 		 	

		 }

	     header('Content-Type: application/json');
	     return Response::json($result);

	}

	public function deleteComment($commentId){

	    if(Activity::deleteComment($commentId)){

	      $result = array(
	          'error'       => false
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);

	}

	public function changeStatus($activityId, $statusId){

	    $values = array(
	      'status'    => $statusId
	    );

	    if(Project::updateActivity($activityId, $values)){

	      $result = array(
	          'error'       => false,
	          'new_status'  => $statusId
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);

	}	


}
