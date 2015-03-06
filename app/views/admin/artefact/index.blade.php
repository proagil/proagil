<!DOCTYPE html>
<html lang="en">

<head>

	@include('admin.includes.head')

</head>

<body>

    <div id="wrapper">

		@include('admin.includes.side_menu')

		@include('admin.includes.top_menu')

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    	<h3><?=Config::get('constant.admin.action.enumerate').' '.Config::get('constant.admin.entity.artefact')?></h3>
						<a type="button" class="add-btn btn btn-info btn-xs">
						  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar
						</a>                    	
						<table class="table table-striped">
						  <tr>
						  	<td>Identificador</td>
							<td>Nombre</td>
							<td>Habilitado</td>
							<td>Acciones</td>
						  </tr>
						  @foreach ($entities as $entity)
						  <tr>
						  	<td>{{$entity->id}}</td>
							<td>{{$entity->name}}</td>
							<td><?=($entity->enabled==TRUE)?'<i class="glyphicon glyphicon-ok"></i>':'<i class="glyphicon glyphicon-remove"></i>'?></td>
							<td>
								<a href="{{URL::action('AdminProjectTypeController@edit', array($entity->id))}}"> <i class="glyphicon glyphicon-edit"></i></a> 
								<a href="{{URL::action('AdminProjectTypeController@delete', array($entity->id))}}"> <i class="glyphicon glyphicon-trash"></i></a> 
							</td>
						  </tr>
						  @endforeach					  
						</table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

	@include('admin.includes.javascript')

	    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>


</body>

</html>
