<!--INIT SIDE MENU !-->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
		<div id="side-wrapper">
			<ul class="nav sidebar-menu" id="side-menu">
				<li>
					<a class="fc-grey-iv" href="{{URL::to('/')}}"><i class="fs-big fc-turquoise fa fa-dashboard fa-fw"></i> Inicio</a>
				</li>
				@if(isset($projectDetail) && $projectDetail)
				<li>
					<a class="fc-grey-iv" href="#"><i class="fs-big fc-turquoise fa fa-folder-open fa-fw"></i> Mis proyectos<span class="fc-green fa arrow"></span></a>
					<ul class="nav sidebar-menu nav-second-level">
						<li>
							<a class="fc-grey-iv" href="#"> <i class="fc-yellow fa fa-bullseye"></i> Proyecto</a>
						</li>
						<li>
							<a class="fc-grey-iv" href="#"> <i class="fc-yellow fa fa-bullseye"></i> Proyecto</a>
						</li>
						<li>
							<a class="fc-grey-iv" href="#"> <i class="fc-yellow fa fa-bullseye"></i> Proyecto</a>
						</li>
						<li>
							<a class="fc-grey-iv" href="#"><i class="fc-yellow fa fa-bullseye"></i> Proyecto</a>
						</li>
						<li>
							<a class="fc-grey-iv" href="#"><i class="fc-yellow fa fa-bullseye"></i> Proyecto</a>
						</li>
						<li>
							<a class="fc-grey-iv" href="#"><i class="fc-yellow fa fa-bullseye"></i> Proyecto</a>
						</li>								
						<li>
							<a class="fc-pink txt-undrln" href="#">ver todos los proyectos</a>
						</li>	
					</ul>
					<!-- /.nav-second-level -->
				</li>
				@endif
				<ul class="nav sidebar-buttons">
					@if(!isset($create_project))
					<li class="btn-sidebar">
						<a class="fc-grey-iv" href="{{URL::action('ProjectController@create')}}"><img src="{{URL::to('/').'/images/add-project.png'}}"/> Crear proyecto</a>
					</li>
					@endif

					@if(isset($projectDetail) && $projectDetail && $projectOwner)
					<li class="btn-sidebar">
						<a class="fc-grey-iv" href="{{URL::action('ProjectController@edit', array($project['id']))}}"><img src="{{URL::to('/').'/images/config-project.png'}}"/> Editar proyecto</a>
					</li>	
					@endif	

					@if(isset($projectDetail) && $projectDetail && $projectOwner)
					<li class="btn-sidebar">
						<a class="fc-grey-iv" href="{{URL::action('ProjectController@editInvitation', array($project['id']))}}"><i class="fc-turquoise fs-big fa fa-users"></i> Invitar a colaboradores</a>
					</li>	
					@endif												
				</ul>
			</ul>
		</div>
    </div>
</div>
<!--END SIDE MENU !-->