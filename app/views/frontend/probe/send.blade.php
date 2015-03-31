<html>

	@include('frontend.includes.head')

	<body>
	    <div class="container">
	        <div class="row show-probe-container">
	            <div class="col-md-8 col-lg-8">
	                <div class="show-probe-panel panel panel-default">
	                    <div class="panel-body">
	                    	  <div class="login-title txt-center fs-big">
	                    	  		Sondeo enviado <br>
	                    	  		<span class="fc-turquoise f-bold fs-med">Su sondeo se ha enviado correctamente </span>                 	  		
	                    	  </div>
				                <div class="brand-img pull-right">
				                	 <span class="login-title txt-center fs-min"> Sondeo generado con: 
										<img  style="width:10%" src="{{URL::to('/').'/images/logo-sm.png'}}"/>
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