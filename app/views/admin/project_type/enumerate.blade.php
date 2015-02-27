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
                    	<h3><?=Config::get('constant.admin.action.enumerate').' '.Config::get('constant.admin.entity.project_type')?></h3>
						<a href="{{URL::action('AdminProjectTypeController@add')}}" class="add-btn btn btn-info btn-xs">
						  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar
						</a> 
	                    @if(isset($error_message))
	                    	<div class="alert alert-danger"><i class="glyphicon glyphicon-remove-sign"></i> {{$error_message}}</div>
	                	@endif						   
						@if (!empty($entities))                	
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
								<a href="{{URL::action('AdminProjectTypeController@delete', array($entity->id))}}"> <i data-entity-id="{{$entity->id}}" class="delete-entity glyphicon glyphicon-trash"></i></a> 
							</td>
						  </tr>
						  @endforeach					  
						</table>
						@else
							<p>No hay entidades que listar </p>
						@endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

	@include('admin.includes.javascript')

	<script>

		$(function(){

            $('.delete-entity').on('click', function(e){

                e.preventDefault();

                var entityId = $(this).data('entityId'); 

                if(confirm('¿Desea eliminar el elemento? ')){

	                var deleteURL = "<?= URL::to('/') . '/admin/tipo-de-proyecto/eliminar/'?>";
	                	
	                window.location.href  = deleteURL+entityId;

                }
            });

        });

	</script>


</body>

</html>
