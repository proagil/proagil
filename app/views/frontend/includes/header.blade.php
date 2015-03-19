        <!-- INIT TOP SECTION -->
        <nav class="top-menu navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header logo-content">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand proagil-logo" href="{{URL::to('/')}}"><img width="33%" src="{{URL::to('/').'/images/logo-sm.png'}}"/></a>
				
            </div>
            <!-- /.navbar-header -->

			@if(isset($project['name']))
			<div class="project-name-content hidden-xs">Proyecto: <span class="fc-pink">{{$project['name']}}</span></div>
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