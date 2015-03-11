<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
    					<div class="section-content">
    						<div class="breadcrumbs-content">
    							Inicio <span class="fc-green"> &raquo; </span> {{$activity['project_name']}} <span class="fc-green"> &raquo; </span> {{$activity['title']}}
    						</div>

                              @if (Session::has('success_message'))
                                <div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                              @endif    
                              <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
            				  <div class="section-title fc-blue-iii fs-big">
            					{{$activity['title']}}
            				  </div>

                              <div class="description-activity-content">
                                  {{$activity['description']}}
                              </div>	

                              <div class="detail-activity-content">
                                  <i class="fs-med fa fa-user fc-turquoise fa-fw"></i> <span class="fc-pink">Asisgnada a:</span> {{$activity['first_name']}} <i class="fs-med fa fa-calendar fc-turquoise fa-fw"></i> <span class="fc-pink"> Fecha:</span> {{$activity['date']}} <i class="fs-med fa fa-tasks fc-turquoise fa-fw"></i> <span class="fc-pink">Estado:</span> {{$activity['status_name']}} <i class="fs-med fa fa-filter fc-turquoise fa-fw"></i> <span class="fc-pink">Categor&iacute;a:</span> {{($activity['category_name']!='')?$activity['category_name']:'Sin categoría'}}
                              </div>                                 

                              <div class="section-title fc-blue-iii fs-big">
                                <i class="fc-turquoise fa fa-comments fa-fw"></i> Comentar
                              </div>

                      <div class="comments-content">
                        <div class="comment-textarea">
                        {{ Form::open(array('action' => array('ActivityController@commnet'), 'id' => 'form-comment-activity')) }}                           
                          {{ Form::textarea('values[comment]', (isset($values['comment']))?$values['comment']:'', array('id' => 'comment-textarea', 'class'=>'form-control app-input', 'rows' => '2')) }}
                          {{ Form::hidden('values[activity_id]', $activity['id']) }}
                        {{Form::close()}}
                        </div>
                        <span class="hidden error fc-pink fs-min">Debe especificar un comentario</span>                          

                        <div class="emoticons-container"></div>
                        <div class="save-comment txt-center fs-med common-btn btn-i btn-turquoise pull-right">
                          Comentar
                        </div>
                        <div class="comment-list">
                        @if(!empty($comments)) 
                            @foreach($comments as $comment)                       
                            <div class="comment-content" id="comment-{{$comment['id']}}">
                                <div class="user-avatar">
                                    @if($comment['user_avatar']>0)
                                        <img class="img-circle comment-user-avatar" src="{{URL::to('/').'/uploads/'. $comment['avatar_file']}}"/>
                                    @else
                                        <img class="img-circle comment-user-avatar" src="{{URL::to('/').'/images/dummy-user.png'}}"/>
                                    @endif
                                </div>
                                <span class="fs-min fc-pink"> {{$comment['user_first_name']}} <i class="fs-med fa fa-calendar fc-turquoise fa-fw"></i> {{$comment['date']}}</span>
                                <div class="comment-text">
                                    {{$comment['comment']}}
                                </div>
                                @if($comment['editable'])
                                <div class="comment-action">
                                  <div  class="btn-delete-comment txt-center fs-big fc-grey-iii" data-comment-id="{{$comment['id']}}">
                                    <i class="fa fa-times fa-fw"></i>
                                  </div>                               
                                </div>
                                @endif
                            </div> 
                            @endforeach
                        </div> 
                        @endif                                                                     
                      </div>
        	       </div>
			     </div>
	           </div>
	        </div>
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
            "talking": {
                "title": "Talking",
                "codes": ["(talk)"]
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
            "call": {
                "title": "Call",
                "codes": ["(call)"]
            },
            "devil": {
                "title": "Devil",
                "codes": ["(devil)"]
            },
            "angel": {
                "title": "Angel",
                "codes": ["(angel)"]
            },
            "envy": {
                "title": "Envy",
                "codes": ["(envy)"]
            },
            "wait": {
                "title": "Wait",
                "codes": ["(wait)"]
            },
            "thinking": {
                "title": "Thinking",
                "codes": ["(think)", ":?", ":-?", ":=?"]
            },
            "rofl": {
                "title": "Rolling on the floor laughing",
                "codes": ["(rofl)"]
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

                $('#comment-textarea').val($('#comment-textarea').val() + ' '+icon); 

           })

      }());
  </script>   

	</body>

</html>
