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
                    	<h3><?=Config::get('constant.admin.action.edit').' '.Config::get('constant.admin.entity.artefact')?></h3>
                         <p><button class="add-btn btn btn-info btn-xs" onclick="goBack()"><i class="glyphicon glyphicon-chevron-left"></i>Volver</button></p>

                        <?= Form::open(array('action' => array('AdminArtefactController@edit', $values->id), 'class' => 'form-horizontal', 'files' => true)) ?> 
                        <fieldset>
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="textinput">Nombre:</label>  
                              <div class="col-md-4">
                                <?= Form::text('values[name]', (isset($values->name))?$values->name:'' , array('class' => 'form-control input-md')) ?>
                                <span class="help-block"><?= ($errors->has('name'))?$errors->first('name'):''?></span>  
                              </div>
                            </div>

                             <div class="form-group">
                              <label class="col-md-4 control-label" for="textinput">Descripci&oacute;n:</label>  
                              <div class="col-md-4">
                                <?= Form::textarea('values[description]', (isset($values->description))?$values->description:'' , array('class' => 'form-control input-md')) ?>
                                <span class="help-block"><?= ($errors->has('description'))?$errors->first('description'):''?></span>  
                              </div>
                            </div>    

                            <div class="form-group">
                              <label class="col-md-4 control-label" for="textinput">Icono:</label>  
                              <div class="col-md-4">
                                <img  src="{{URL::to('/').'/uploads/'.$values->icon_file}}"/>
                                <?= Form::file('icon', array('id'=> 'artefact-icon', 'class'=> 'file-upload')) ?>
                              </div>
                            </div>                            

                            <div class="form-group">
                              <label class="col-md-4 control-label" for="checkboxes">Habilitado:</label>
                              <div class="col-md-4">
                                  <?=  Form::checkbox('values[enabled]', TRUE, (isset($values->enabled) && $values->enabled=='1')?TRUE:FALSE);?> 
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-4">
                                <button type="submit" name="singlebutton" class="btn btn-primary">Guardar</button>
                              </div>
                            </div>
                        </fieldset>
                        <?=  Form::close() ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

	@include('admin.includes.javascript')

    <script>
        function goBack() {
            window.history.back()
        }
    </script>    



</body>

</html>
