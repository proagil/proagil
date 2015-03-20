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
        								Inicio <span class="fc-green"> &raquo; </span> Proyecto <span class="fc-green"> &raquo; </span> Enviar Invitaci&oacute;n
        							</div>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif    

                      <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>

        							<div class="section-title fc-blue-iii fs-big">
        								Enviar Invitaci&oacute;n
        							</div>

                      <div class="form-content">
                        {{ Form::open(array('action' => array('ProjectController@invitation'), 'id' => 'form-send-invitations')) }}							
                         
                          <div class="invitation-content user-invitation-0">
                            <div class="form-group">
                              <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Invitar a</label>  
                              <div class="col-md-8">
                                {{ Form::text('invitations[email][]', (isset($values['email']))?$values['email']:'', array('placeholder' => 'Correo electr&oacute;nico', 'class'=>'form-control app-input-invitation invitation-email app-input')) }}
                                {{ Form::select('invitations[role][]', $userRoles, Config::get('constant.project.member') , array('class'=>'form-control app-input-invitation app-input')) }}
                                <div data-invitation-id="0" class="btn-delete-invitation  circle activity-option txt-center fs-big fc-pink">
                                  <i class="fa fa-times fa-fw"></i>
                                </div>
                                <br><br>
                                <span class="error fc-pink fs-min hidden">El correo electr&oacute;nico indicado no es v&aacute;lido</span>
                              </div>
                            </div>                           
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">&nbsp;</label>  
                            <div class="col-md-4">
                              <div class="btn-add-invitation">
                                <div class="circle activity-option txt-center fs-big fc-turquoise">
                                  <i class="fa fa-plus fa-fw"></i>
                                </div>
                                <span class="fc-turquoise fs-min">Hacer clic para agregar usuario a invitar</span> 
                              </div>
                            </div> 
                          </div>

                          <div class="form-group">
                               <div class="col-md-8 btn-save-invitations common-btn btn-ii btn-turquoise txt-center btn-send-invitations">Guardar</div> 
                          </div>

                          <div class="form-group">
                             <div class="col-md-8 fc-blue-ii"> 
                              Deseo enviar invitaciones despu&eacute;s. Para ir al proyecto hacer clic
                                <a class="txt-undrln" href="{{URL::action('ProjectController@detail', array($projectId))}}">aqu&iacute;</a>
                              </div>
                          </div>
                         
                          {{Form::close()}}
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

    $(function() {

      var userRoles = <?= json_encode($userRoles) ?>,
          defaultRoleValue = <?= Config::get('constant.project.member') ?>,
          htmlInvitation = '',
          invitationCount = 0; 

          $('.btn-add-invitation').on('click', function(){

            invitationCount++; 

            htmlInvitation +=  '<div class="form-group user-invitation-'+invitationCount+'" style="display:none">'+
                                  '<label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Invitar a</label>'+
                                    '<div class="col-md-8">'+
                                        '<input placeholder="Correo electr&oacute;nico" class="form-control app-input-invitation app-input invitation-email" name="invitations[email][]" type="text">'+
                                        '<select class="form-control app-input-invitation app-input" name="invitations[role][]">';
                                          $.each(userRoles, function(index, role) {
                                            var selected = (index==defaultRoleValue)?'selected':''; 
                                            htmlInvitation += '<option value="'+index+'"'+selected+'>'+role+'</option>';
                                          });
                                  
                      htmlInvitation += '</select>'+
                                      '<div data-invitation-id="'+invitationCount+'" class="btn-delete-invitation circle activity-option txt-center fs-big fc-turquoise">'+
                                        '<i class="fa fa-minus fa-fw"></i>'+
                                      '</div>'+
                                      '<br><br>'+
                                      '<span class="error fc-pink fs-min hidden">El correo electr&oacute;nico indicado no es v&aacute;lido</span>'+
                                    '</div>'+
                                  '</div>';  

                      $(htmlInvitation).appendTo('.invitation-content').fadeIn('slow');
  

              htmlInvitation = '';

          });

        $(document).on('click','.btn-delete-invitation', function(){

          var invitationId = $(this).data('invitationId'); 

           $(document).find('.user-invitation-'+invitationId).fadeOut('slow', 
              function() { 
                $(this).remove()
              });
        });

        $('.btn-send-invitations').on('click', function(){

          var regexEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
              successValidation = false,
              totalInvitations = 0;

              //validate emails
              $('.invitation-email').each(function(){

                totalInvitations++; 

                if($(this).val() == '' || !regexEmail.test($(this).val())){
                  $(this).siblings('.error').removeClass('hidden'); 
                }else{
                   $(this).siblings('.error').addClass('hidden');
                    successValidation++; 
                }
              });

              // success validation, all email are valid
              if(successValidation==totalInvitations){
                $(document).find('#form-send-invitations').submit()
              }              

          //

        })

    });

    </script>
	</body>

</html>
