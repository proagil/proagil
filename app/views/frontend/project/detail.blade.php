<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
						<div class="activities-content">
		                	
							<div class="breadcrumbs-content">
								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> {{$iteration['name']}}
							</div>

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>	

							@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif	

		                	@if (Session::has('error_message'))
		                		<div class="error-alert-dashboard"><i class="fc-pink glyphicon glyphicon-alert"></i> {{Session::get('error_message')}}</div>
		                	@endif														
							
							<div class="artefacts-content">

								<div class="fs-med tags-list tags-list-i" style="margin: 2% 0 0 0">
									<span class="fs-big fc-pink fa fa-rotate-right fa-fw"></span><span class="f-bold">Iteraciones </span>
									@foreach($projectIterations as $projectIteration)
										@if($projectIteration['id']==$iteration['id'])
											<a class="selected-tag tags-list-on btn-filter-iteration iteration-tag" data-iteration-id="{{$projectIteration['id']}}" data-project-id="{{$projectId}}">
												Iteraci&oacute;n {{$projectIteration['order']}}: {{$projectIteration['name']}}
											</a>
										@else 
											<a href="#" class="unselected-tag tags-list-off btn-filter-iteration iteration-tag" data-iteration-id="{{$projectIteration['id']}}" data-project-id="{{$projectId}}">
												{{$projectIteration['order']}}
											</a>
										@endif
									@endforeach

									@if($projectOwner)
									<a href="{{URL::action('ActivityCategoryController@edit', array($project['id']))}}"><span class="fs-med fc-turquoise fa fa-cog fa-fw"></span><span class="fs-min">Configurar iteraciones</span></a>
									@endif									
									
								</div>	

								<span class="fs-big fc-green fa fa-calendar-o fa-fw"></span><span class="f-bold">Periodo de iteraci&oacute;n:</span> Desde {{$iteration['init_date']}} hasta {{$iteration['end_date']}} 															

								<div class="section-title fc-blue-iii fs-big">
									Artefactos
									@if(!empty($iterationArtefacts))
									<div data-section="section-artefatcs" class="section-arrow pull-right"><i class="fc-green fa fa-caret-down fa-fw"></i>
									</div>
									@endif
								</div>
								
								<div id="section-artefatcs" class="showed section-artefatcs">

									@if($projectOwner)
									<div class=" fs-med common-btn-ii btn-i btn-green pull-right btn-add-activity" data-project-id="{{$project['id']}}">
										<i class="fs-big fa fa-plus fa-fw"></i>Agregar artefacto
									</div>
									@endif

									<div class="fc-grey-ii fs-xxbig arrow-left prev"  {{($projectArrows)?'style="visibility:visble"':'style="visibility:hidden"'}}>
										<i class="fa fa-chevron-left fa-fw"></i>
									</div>

									@if(!empty($iterationArtefacts))
									<div class="artefacts-list">								
										@foreach($iterationArtefacts as $iterationArtefact)
										<div class="slide">
											<div class="artefact">
												@if($projectOwner)
												<i class="fs-med fa fa-times fc-pink fa-fw pull-right"></i>
												@endif

												<div class="artefact-icon artefact-detail" data-project-id="{{$iteration['id']}}" data-friendly-url="{{$iterationArtefact['friendly_url']}}">
													<img width="100%" src="{{URL::to('/').'/uploads/'.$iterationArtefact['icon_file']}}"/>
												</div>
												
												<div class="artefact-info txt-center artefact-detail" data-project-id="{{$projectId}}" data-friendly-url="{{$iterationArtefact['friendly_url']}}">
													{{$iterationArtefact['name']}} 
												</div>

											</div>
										</div>
										@endforeach																	
									</div>
									@else
									<div class="txt-center fs-med">
										<i class="fa  fa-frown-o fc-yellow fa-fw"></i> A&uacute;n no hay artefactos asociados al proyecto. @if($projectOwner) Para crear alg&uacute;n artefacto haga clic 
										
										<a class="txt-undrln" href="{{URL::action('ProjectController@edit', array($project['id']))}}"> aqu&iacute; </a> 
									@endif
									</div>
									@endif

									<div class="fc-grey-ii fs-xxbig arrow-left next" {{($projectArrows)?'style="visibility:visble"':'style="visibility:hidden"'}}>
										<i class="fa fa-chevron-right fa-fw"></i>
									</div>										
								</div>
							</div>

							<div class="section-title fc-blue-iii fs-big">
								Actividades
								<div data-section="section-activities" class="section-arrow pull-right"><i class="fc-green fa fa-caret-down fa-fw"></i></div>
							</div>	

							<div id="section-activities" class="showed detail-project-activities">

								<div class="filters-content">
							
									{{ Form::open(array('action' => array('ProjectController@detail', $project['id']), 'id' => 'form-filter-activity')) }}
                     					 {{ Form::hidden('filters[category]', (isset($filters['category']))?$filters['category']:'') }}
                     					  {{ Form::hidden('filters[status]', (isset($filters['status']))?$filters['status']:'') }}
                   					{{Form::close()}}															
							
									<div class="fs-med tags-list">
										<span class="fs-big fc-pink fa fa-filter fa-fw"></span><span class="f-bold">Categor&iacute;a </span>
										

										<a href="#" data-category-id="ALL" class="hidden btn-filter tags-list-on">Todas</a>

										@if(!empty($activityCategories))
											@foreach($activityCategories as $activityCategory)
												<a href="#" data-category-id="{{$activityCategory->id}}" class="{{(in_array($activityCategory->id, $filtersArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-filter">{{$activityCategory->name}}</a>
											@endforeach									
										@endif

										@if($projectOwner)
										<a href="{{URL::action('ActivityCategoryController@edit', array($project['id']))}}"><span class="fs-med fc-turquoise fa fa-cog fa-fw"></span><span class="fs-min">Configurar categor&iacute;as</span></a>
										@endif

									</div>
									
									<div class="fs-med tags-list tags-list-i">
										<span class="fs-big fc-pink fa fa-tasks fa-fw"></span><span class="f-bold">Estado </span>
										
										<a href="#" class="{{(in_array('1', $statusArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-status" data-status-id="1">Asignadas</a>
										<a href="#" class="{{(in_array('2', $statusArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-status" data-status-id="2">Iniciadas</a>
										<a href="#" class="{{(in_array('3', $statusArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-status" data-status-id="3">Terminadas</a>

									</div>
									@if($projectOwner)
									<div class=" fs-med common-btn-ii btn-i btn-green pull-right btn-add-activity" data-project-id="{{$project['id']}}">
										<i class="fs-big fa fa-plus fa-fw"></i>Agregar actividad
									</div>
									@endif
								</div>	
								
								<div class="list-activities-content">
									@if(!empty($activities))
										@foreach($activities as $activity)
										<div class="each-activity-content activity-{{$activity['id']}}">
											<div class="btn-change-status">
												<i class="btn-change-activity-status fs-big fa fa-check-circle {{$activity['status_class']}} fa-fw" data-activity-id="{{$activity['id']}}" data-activity-status="{{$activity['status']}}"></i>	
											</div>
											<div style="width:{{($projectOwner)?'88%':'95%'}}" class="activity" data-activity-id="{{$activity['id']}}">
												<div data-activity-id="{{$activity['id']}}" class="activity-info btn-activity-description">
						
													<span class="{{($activity['status']==3)?'txt-strike':''}} activity-title-{{$activity['id']}}"> {{$activity['title']}} </span>
													
													<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>{{$activity['first_name']}}</span>
													
												</div>

												<div class="activity-description fc-grey-v" style="display:none;" id="description-{{$activity['id']}}">

													<div class="activity-info-ii">

						                              <div class="detail-activity-content">
						                                  <i class="fs-med fa fa-user fc-turquoise fa-fw"></i> <span class="fc-pink">Asignada a:</span> {{$activity['first_name']}} 
						                                  @if($projectOwner)
							                                  <a href="#" data-toggle="modal" data-target="#reassignModal-{{$activity['id']}}" class="btn-reassign"><i class="fs-med fa fa-retweet fc-turquoise fa-fw"></i> Reasignar</a>
							                                  <!-- INIT MODAL HTML TO REASSIGN ACTIVITY -->
							                                  <div class="modal fade" id="reassignModal-{{$activity['id']}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
																    <div class="modal-dialog">
																        <div class="modal-content" style="border-radius:0px;">
																            <div class="modal-header">
																	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="fs-med fa fa-times fc-pink fa-fw"></i></button>
																	            <h4 class="fs-med text-center f-bold fc-turquoise" id="myModalLabel">Reasignar Actividad: {{$activity['title']}}</h4>
																            </div>
																            <div class="modal-body">
																            	<div class="form-group-modal">
																            	{{ Form::open(array('action' => array('ActivityController@reassign', $activity['id'] ), 'id' => 'form-reassign-activity-'.$activity['id'])) }}
																	            	<label  class=" col-md-4 control-label">Reasignar actividad</label>
																	            	<div class="col-md-8">
																	           		{{ Form::select('values[assigned_user_id]', $usersOnIteration, '' , array('class'=>'form-control app-input', 'id'=> 'assigned-user-'.$activity['id'])) }}
																	           		<span class="error-modal-{{$activity['id']}} fc-pink fs-min hidden">Debe seleccionar el usuario</span>
																                	</div>
																                {{Form::close()}}
																                </div>
																            </div>
																            <div class="modal-footer">
																            	<div class="save-comment txt-center fs-med common-btn btn-modal-i btn-pink" data-dismiss="modal">
										                          					Cerrar
										                        				</div>
																            	<div data-activity-id="{{$activity['id']}}" class="btn-reassign-activity txt-center fs-med common-btn btn-modal-ii btn-yellow">
										                          					Reasignar
										                        				</div>	
																        	</div>
																    	</div>
																  	</div>
															  </div>
															  <!-- END MODAL HTML TO REASSIGN ACTIVITY -->
														  @endif
						                                  <i class="fs-med fa fa-calendar fc-turquoise fa-fw"></i> <span class="fc-pink"> Fecha tope:</span> {{$activity['closing_date']}} 
						                                  <i class="fs-med fa fa-tasks fc-turquoise fa-fw"></i> <span class="fc-pink">Estado:</span> {{$activity['status_name']}} 
						                                  <i class="fs-med fa fa-filter fc-turquoise fa-fw"></i> <span class="fc-pink">Categor&iacute;a:</span> {{($activity['category_name']!='')?$activity['category_name']:'Sin categoría'}}
						                              </div>  

						                              <div class="description-activity-content">
						                                  {{$activity['description']}}
						                              </div>

								                      
								                       <div class="comment-textarea">
								                        {{ Form::open(array('action' => array('ActivityController@commnet'), 'id' => 'form-comment-activity-'.$activity['id'])) }}                           
								                          {{ Form::textarea('values[comment]', (isset($values['comment']))?$values['comment']:'', array('id' => 'comment-textarea-'.$activity['id'], 'class'=>'form-control app-input', 'rows' => '2')) }}
								                          {{ Form::hidden('values[activity_id]', $activity['id']) }}
								                        {{Form::close()}}
								                        </div>
								                        <span class="hidden error fc-pink fs-min">Debe especificar un comentario</span>                          
														<i class="fs-med fa fa-smile-o cur-point fc-turquoise fa-fw emojis-popover" data-activity-id="{{$activity['id']}}"></i>
								                        <div style="display:none;" class="emoticons-container-{{$activity['id']}} emoticons-container"></div>

								                        <div data-activity-id="{{$activity['id']}}" class="save-comment txt-center fs-med common-btn btn-i btn-turquoise pull-right">
								                          Comentar
								                        </div>													

													</div>													

							                         @if(!empty($activity['comments']))			                         
							                        <div class="comment-list comment-list-{{$activity['id']}}">
							                            @foreach($activity['comments'] as $comment)                       
							                            <div class="comment-content" id="comment-{{$comment['id']}}">
							                                <div class="user-avatar">
							                                    @if($comment['user_avatar']>0)
							                                        <img class="img-circle comment-user-avatar" src="{{URL::to('/').'/uploads/'. $comment['avatar_file']}}"/>
							                                    @else
							                                        <img class="img-circle comment-user-avatar" src="{{URL::to('/').'/images/dummy-user.png'}}"/>
							                                    @endif
							                                </div>
							                                <span class="f-bold fs-min"> {{$comment['user_first_name']}} <i class="fs-med fa fa-calendar-o fc-green fa-fw"></i> {{$comment['date']}}</span>
							                                <div class="comment-text">
							                                    {{$comment['comment']}}
							                                </div>
							                                @if($comment['editable'])
							                                <div class="comment-action">
							                                  <div  class="btn-delete-comment txt-center fs-big fc-grey-iii" data-comment-id="{{$comment['id']}}">
							                                    <i class="fa fa-times fc-pink fa-fw"></i>
							                                  </div>                               
							                                </div>
							                                @endif
							                            </div> 
							                            @endforeach
							                        </div> 
							                        @endif  					                              	

												</div>							
											</div>							
											@if($projectOwner)
											<div class="activity-options txt-center">
												<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big btn-edit-activity-id" data-activity-id="{{$activity['id']}}">
													<a href="{{URL::action('ActivityController@edit', array($activity['id']))}}">
														<i class="fa fa-pencil fc-yellow fa-fw"></i>
													</a>
												</div>	
												<div data-toggle="tooltip" data-placement="top" title="Eliminar" class="circle activity-option txt-center fs-big fc-pink btn-delete-activity" data-activity-id="{{$activity['id']}}">
													<i class="fa fa-times fa-fw"></i>
												</div>											
																											
											</div>
											@endif
										</div>
										@endforeach
									@else
									<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay actividades para mostrar</div>
									@endif											
								
								</div>
							</div>
							

		
						</div>
					</div>
	                <!-- /.col-lg-12 -->
	            </div>
	            <!-- /.row -->

	        </div>
	        <!-- /#page-wrapper -->

	    </div>
	    <!-- /#wrapper -->

		@include('frontend.includes.javascript')
  <script>
      (function() {
        var definition = {
            "smile": {
                "title": "Smile",
                "codes": [":)", ":=)", ":-)"]
            },
            "sad-smile": {
                "title": "Sad Smile",
                "codes": [":(", ":=(", ":-("]
            },
            "big-smile": {
                "title": "Big Smile",
                "codes": [":D", ":=D", ":-D", ":d", ":=d", ":-d"]
            },
            "heart": {
                "title": "Heart",
                "codes": ["<3"]
            },            
            "cool": {
                "title": "Cool",
                "codes": ["8)", "8=)", "8-)", "B)", "B=)", "B-)"]
            },
            "wink": {
                "title": "Wink",
                "codes": [":o", ":=o", ":-o", ":O", ":=O", ":-O"]
            },
            "crying": {
                "title": "Crying",
                "codes": [";(", ";-(", ";=("]
            },
            "sweating": {
                "title": "Sweating",
                "codes": ["(:|"]
            },
            "speechless": {
                "title": "Speechless",
                "codes": [":|", ":=|", ":-|"]
            },
            "kiss": {
                "title": "Kiss",
                "codes": [":*", ":=*", ":-*"]
            },
            "tongue-out": {
                "title": "Tongue Out",
                "codes": [":P", ":=P", ":-P", ":p", ":=p", ":-p"]
            },
            "blush": {
                "title": "Blush",
                "codes": [":$", ":-$", ":=$"]
            },
            "wondering": {
                "title": "Wondering",
                "codes": [":^)"]
            },
            "sleepy": {
                "title": "Sleepy",
                "codes": ["|-)", "I-)", "I=)", "(snooze)"]
            },
            "dull": {
                "title": "Dull",
                "codes": ["|(", "|-(", "|=("]
            },
            "in-love": {
                "title": "In love",
                "codes": ["(inlove)"]
            },
            "evil-grin": {
                "title": "Evil grin",
                "codes": ["]:)", ">:)", "(grin)"]
            },
            "yawn": {
                "title": "Yawn",
                "codes": ["(yawn)", "|-()"]
            },
            "puke": {
                "title": "Puke",
                "codes": [":&", ":-&", ":=&"]
            },
            "angry": {
                "title": "Angry",
                "codes": [":@", ":-@", ":=@", "x(", "x-(", "x=(", "X(", "X-(", "X=("]
            },
            "party": {
                "title": "Party!!!",
                "codes": ["(party)"]
            },
            "worried": {
                "title": "Worried",
                "codes": [":S", ":-S", ":=S", ":s", ":-s", ":=s"]
            },
            "mmm": {
                "title": "Mmm...",
                "codes": ["(mm)"]
            },
            "nerd": {
                "title": "Nerd",
                "codes": ["8-|", "B-|", "8|", "B|", "8=|", "B=|", "(nerd)"]
            },
            "lips-sealed": {
                "title": "Lips Sealed",
                "codes": [":x", ":-x", ":X", ":-X", ":#", ":-#", ":=x", ":=X", ":=#"]
            },
            "hi": {
                "title": "Hi",
                "codes": ["(hi)"]
            },
            "angel": {
                "title": "Angel",
                "codes": ["(angel)"]
            },
            "wait": {
                "title": "Wait",
                "codes": ["(wait)"]
            },
            "thinking": {
                "title": "Thinking",
                "codes": ["(think)", ":?", ":-?", ":=?"]
            },
            "whew": {
                "title": "Whew",
                "codes": ["(?)"]
            },
            
        };

          $.emoticons.define(definition);

          $('.emoticons-container').html($.emoticons.toString());

           $('.comment-text').each(function(){

            $(this).html($.emoticons.replace($(this).text()));

           });

           $(document).on('click','.emoticon', function(){

                var icon = $(this).text();

                activityId = $(this).parent().attr('data-activity-id');

                $('#comment-textarea-'+activityId).val($('#comment-textarea-'+activityId).val() + ' '+icon); 

                $('.emojis-popover').popover('hide'); 

           })

      }());
  </script>   

		
	</body>

</html>
