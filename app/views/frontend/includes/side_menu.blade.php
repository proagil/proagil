<!--INIT SIDE MENU !-->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
		<div id="side-wrapper">
			<ul class="nav sidebar-menu" id="side-menu">
				<li>
					<a class="fc-grey-iv" href="index.html"><i class="fc-turquoise fa fa-dashboard fa-fw"></i> Inicio</a>
				</li>
				@if(!isset($dashboard))
				<li>
					<a class="fc-grey-iv" href="#"><i class="fc-turquoise fa fa-folder-open fa-fw"></i> Mis proyectos<span class="fc-green fa arrow"></span></a>
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
					<li class="btn-sidebar">
						<a class="fc-grey-iv" href="#"><img src="../images/add-project.png"/> Crear proyecto</a>
					</li>
					@if(!isset($dashboard))
					<li class="btn-sidebar">
						<a class="fc-grey-iv" href="#"><img src="../images/config-project.png"/> Configurar proyecto</a>
					</li>	
					@endif						
				</ul>
			</ul>
		</div>
    </div>
</div>
<!--END SIDE MENU !-->