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
        								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> Generar Tormenta de Ideas
        							</div>
                      <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::action('StormIdeasController@index', array($project['id']))}}" > Volver</a> 
                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif                          
        							
                      <div class="section-title fc-blue-iii fs-big">
        								Tormenta de Ideas
        							</div>

                      <div class="form-content">
                        <div class="form-group">
                          <div class="col-md-12">
                            <p class="text-center fc-turquoise f-bold fs-big text-uppercase">{{$stormIdeas['name']}}</p>
                          </div>
                        </div>
                        <div id="storm-ideas" class="storm-ideas">
                        @foreach($stormIdeasWords as $stormIdeasWord)
                          <span data-weight="{{$stormIdeasWord['weight']}}">{{$stormIdeasWord['word']}}</span> 
                        @endforeach
                        </div>
                          <div class="btn-download-storm-ideas common-btn btn-ii btn-turquoise txt-center "> <a id="download"> <i class="fa fa-cloud-download fa-fw"></i> Descargar</a></div>
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

  <script>

    $(document).ready(function(){
      
      $("#storm-ideas").awesomeCloud({
        "size" : {
          "grid" : 8, // word spacing, smaller is more tightly packed
          "factor" : 20, // font resize factor, 0 means automatic
          "normalize" : false //reduces outliers for more attractive output
        },
        "color" : {
          "background" : "#ffffff", // background color, transparent by default
          "start" : "#eecb44", // color of the smallest font, if options.color = "gradient""
          "end" : "#ef6f66" // color of the largest font, if options.color = "gradient"
        },
        "options" : {
          "color" : "gradient", // random-light, random-dark, gradient
          "rotationRatio" : 0.35, // 0 is all horizontal, 1 is all vertical
          "printMultiplier" : 3, // set to 3 for nice printer output; higher numbers take longer
          "sort" : "random" // highest, lowest or random
        },
        "font" : "'cabin_condensedregular'", //  the CSS font-family string
        "shape" : "square" // circle, square, star or a theta function describing a shape
      });

    });

  </script>

  <script>
    $(document).ready(function(){
      var canvas = document.getElementById('awesomeCloudstorm-ideas');

      function downloadCanvas(link, canvasId, filename) {
          link.href = document.getElementById(canvasId).toDataURL();
          link.download = filename;
      }

      document.getElementById('download').addEventListener('click', function() {
          downloadCanvas(this, 'awesomeCloudstorm-ideas', '<?php echo $stormIdeas["name"]; ?>.png');
      }, false);
    });
  
  </script>
  
  <script>
  
    window.onload = function() {
      
      setTimeout(function() {
        
        var canvas = document.getElementById('awesomeCloudstorm-ideas');
          var dataURL = canvas.toDataURL();

          $.ajax({ 
            type: "POST", url: projectURL+"/tormenta-de-ideas/guardar-imagen/<?php echo $stormIdeasId; ?>/<?php echo $stormIdeas['name']; ?>",
            data: { 
              imgBase64: dataURL 
            } 
          }).done(function(o) { 
            console.log('saved'); 
          });

      }, 1500);

    };

</script>

</html>
