<html>

	@include('frontend.includes.head')

	<body>
	    <div class="container">
	        <div class="row show-probe-container">
	            <div class="col-md-8 col-lg-8">
	                <div class="show-probe-panel panel panel-default">
	                    <div class="panel-body">
	                    	  <div class="login-title fc-turquoise txt-center fs-big">
	                    	  		Sondeo enviado <br>
	                    	  		<span class=" fc-blue-i f-bold fs-med">Muchas gracias por responder el sondeo. Sus respuestas se han guardado correctamente </span>                 	  		
	                    	  </div>
				                <div class="brand-img pull-right">
				                	 <span class="login-title txt-center fs-min"> Sondeo generado con: 
										<a href="{{URL::to('/')}}"> <img  style="width:10%" src="{{URL::to('/').'/images/logo-sm.png'}}"/></a>
				                	 </span>
				                	 
				                </div>		                    	  	 
	                    </div>
	                </div>

	            </div>
	        </div>
	    </div>	

		@include('frontend.includes.javascript')

	</body>

</html>