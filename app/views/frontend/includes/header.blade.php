        <!-- INIT TOP SECTION -->
        <nav class="top-menu navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header logo-content">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="hidden-xs navbar-brand proagil-logo" href="{{URL::to('/')}}"><img width="33%" src="{{URL::to('/').'/images/logo-sm.png'}}"/></a>
				
            </div>
            <!-- /.navbar-header -->

			@if(isset(Session::get('project')['name']))
			<div class="project-name-content hidden-xs">Proyecto: <span class="fc-pink">{{Session::get('project')['name']}}</span>
            <span data-project-id="{{Session::get('project')['id']}}" class="btn-project-description cur-point fs-med fa fa-info-circle fc-green fa-fw"></span>

                @if(isset($projectOwner)  && $projectOwner)
                <a href="{{URL::action('ProjectController@editInfo', array(Session::get('project')['id']))}}">
                    <span class="cur-point fs-med fa fa-pencil fc-yellow fa-fw"></span>
                </a> 
                @endif
             </div>   
            @endif

            <div class="loader" style="display:none;">
                 <img class="img-circle user-profile" src="{{URL::to('/').'/images/loader.gif'}}"/>
            </div>

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown hidden-xs">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        @if(isset(Session::get('user')['avatar_file']))
                            <img class="img-circle user-profile" src="{{URL::to('/').'/uploads/'.Session::get('user')['avatar_file']}}"/>
                        @else
                            <img class="img-circle user-profile" src="{{URL::to('/').'/images/dummy-user.png'}}"/>
                        @endif
                            <span class="fc-turquoise"> {{Session::get('user')['first_name'].' '.Session::get('user')['last_name'] }} </span> <i class="fc-green fa fa-caret-down"></i>
                    </a>
                    <ul class="user-profile-options dropdown-menu dropdown-user">
                        <li><a href="{{URL::action('UserController@edit', array(Session::get('user')['id']))}}"><i class="fa fc-green fa-gear fa-fw"></i> Editar Perfil</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{URL::action('UserController@information')}}"><i class="fa fc-green fa-info fa-fw"></i> Acerca de</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{URL::action('LoginController@logout')}}"><i class="fa fc-green fa-sign-out fa-fw"></i> Cerrar Sesi&oacute;n</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
                @include('frontend.includes.side_menu')
        </nav>
        <!-- END TOP SECTION -->

       <!-- INIT MODAL: artefact description -->
      <div class="modal fade" id="project-info-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:0px;">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="fs-med fa fa-times fc-pink fa-fw"></i></button>
                      <div class="fs-med text-center f-bold fc-turquoise artefact-name-i" >Informaci&oacute;n</div>
                    </div>
                    <div class="modal-body">
                      <div class="form-group-modal">
                        <label  class=" control-label">Objetivos</label>
                            <div class="artefact-description">
                                {{Session::get('project')['objetive']}}
                            </div>
                        </div>
                      <div class="form-group-modal">
                        <label  class=" control-label">Cliente</label>
                            <div class="artefact-description">
                                {{Session::get('project')['client']}}
                            </div>
                        </div>                        
                    </div>
              </div>
            </div>
        </div>
        <!-- END MODAL: artefact description -->           