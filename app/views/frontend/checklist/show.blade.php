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
        								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> Lista de Comprobación
        							</div>
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
                      <div class="section-title fc-blue-iii fs-big">
        								Lista de Comprobación 
        							</div>
                      <div class="form-content">
                          <div class="form-group">
                            <div class="col-md-12">
                              <p class="text-center fc-turquoise f-bold fs-big text-uppercase">{{$checklist['title']}}</p>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-8 col-md-push-4 ">
                                </br>
                                @foreach($checklistItems as $checklistItem)
                                  <div class="form-group">
                                    <div class="fs-med" >
                                        <i class="{{$checklistItem['status']==1 ?'fc-green fa-check':'fc-pink fa-times'}} fs-med fa fa-fw f-bold"></i>
                                        {{$checklistItem['rule']}}
                                        <i style="cursor:pointer;" data-container="body" data-toggle="popover" data-placement="right" data-content="{{$checklistItem['description']}}" class="fc-turquoise fa fa-info-circle fa-fw"></i>
                                    </div>
                                  </div> 
                                @endforeach
                            </div>
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

	</body>

</html>
