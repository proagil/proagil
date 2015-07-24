
/* paper del stencil_container*/
var graph = new joint.dia.Graph;
var paper = new joint.dia.Paper({
    el: $('.stencil_container'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph,
    interactive: false,
    width: 200
    
});

/* paper del contenedor de las figuras*/
var graph2 = new joint.dia.Graph;
var paper2 = new joint.dia.Paper({
    el: $('.paper'),
    gridSize: 50,
    perpendicularLinks: false,
    model: graph2,
    width: 1000,
    height: 1000,
    embeddingMode: true,
    
    defaultLink: function() {

       if (document.getElementById("dropdownlineas").className== "0"){

        return new joint.dia.Link;

       } else if(document.getElementById("dropdownlineas").className== "1"){

        return new joint.dia.Link({

            source: { },
            target: { },
             attrs: {
                
                '.connection': {
                    'stroke-width': 1,
                    'stroke-dasharray': [5,5],
                    stroke: 'black'
                 }
            } 

        })

      } else if (document.getElementById("dropdownlineas").className== "2"){


        return new joint.dia.Link({

            source: { },
            target: { },
             attrs: {
                
                '.marker-target': {
                    d: 'M 10 0 L 0 5 L 10 10 z'
                }
            }

         })
      }
    
    }
});



var image = new joint.shapes.basic.Image({
    position : {
        x : 30,
        y : 20
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        text: { text: 'Usuario'},
        image : {
          'xlink:href' : '/images/actor.png',
            width : 100,
            height : 100
        }
    }
});


var erd = joint.shapes.erd;


var elipse = new erd.Normal({  

      size: {
            width: 130,
            height: 70
        },
      position: { 

            x: 20, y: 165

        },
      attrs: {
            elipse: {
                rx: 10,
                ry: 10,
                stroke: '#00000',
                fill: '#FFFFFF',
                inPorts: ['in1','in2'],


                
            },
            text: {
                text: "    Uso   ",
                fill: "black",
                "font-size": 20,
                stroke: "#000000",
                "stroke-width": 0,

            }
        }

});



var rect= new joint.shapes.basic.Rect({
        size: {
            width: 100,
            height: 98
        },
        position: { 

        	x: 35, y: 270 

        },
        attrs: {
            rect: {
                rx: 10,
                ry: 10,
                width: 600,
                height: 600,
                stroke: "#000000",
                'stroke-width': 2,
                fill: "#ffffff",
                
                
            },
            text: {
                text: "cuadrado",
                fill: "#000000",
                "font-size": 10,
                stroke: "#000000",
                "stroke-width": 0,
                
            }
        }
});


var textos = new joint.shapes.basic.Text({

          position: {
              x: 50,
              y: 400

          },

          size: {
              width: 80, 
              height: 30 
          },
          
          attrs: {
            text: { 

              text: "Texto",
              fill: "black",
              
               

            }
          }

                

});
var include = new joint.shapes.basic.Text({

          position: {
              x: 30,
              y: 450

          },

          size: {
              width: 70, 
              height: 20 
          },
          
          attrs: {
            text: { 

              text: "<<include>>",
              fill: "black",
              "font-size": 5,
               

            }
          }

               

});

var exclude = new joint.shapes.basic.Text({

          position: {
              x: 110,
              y: 450

          },

          size: {
              width: 70, 
              height: 20 
          },
          
          attrs: {
            text: { 

              text: "<<exclude>>",
              fill: "black",
              "font-size": 5,
               

            }
          }

               

});



/*Se agregan las imagenes en el stencil*/
graph.addCell(image)
graph.addCell(rect)
graph.addCell(elipse)
graph.addCell(textos)
graph.addCell(include)
graph.addCell(exclude)

var selected;
var selected2;


/*Funcion que devuelve la imagen, que el usuario le dio click, al contenedor*/
paper.on('cell:pointerdown ', function(cellView,evt, x, y) { 

    if (cellView.model.id == rect.id) {


       var rect2 = rect.clone();
       rect2.attr('rect/magnet', true);
        graph2.addCell(rect2)
    
    }else if (cellView.model.id == elipse.id) {

        var elipse2 = elipse.clone();
        elipse2.attr('ellipse/magnet', true);

        graph2.addCell(elipse2)

    }else if (cellView.model.id == image.id) {

        var actor = image.clone();

        actor.attr('image/magnet', true);
        graph2.addCell(actor)

    }else if(cellView.model.id == textos.id){   

        var tx = textos.clone();
         graph2.addCell(tx)

    }else if(cellView.model.id == include.id){   

        var incld = include.clone();
         graph2.addCell(incld)

    }else if(cellView.model.id == exclude.id){   

        var excld = exclude.clone();
         graph2.addCell(excld);
    };

    
})

/*Se agrega una clase a los elementos del contenedor*/
paper.$el.addClass('cursor');


// cache important html elements
var $sx = $('#sx');
var $wh = $('#wh');
var $hg= $('#hg')
var $texto = $('#texto');
var $ps = $('#ps');
var $rotar = $('#rotar');
var tam;

$sx.on('input change', function() {
    paper2.scale(parseFloat(this.value), parseFloat(this.value));
});

$ps.on('input change', function() {
    paper2.setDimensions(parseFloat(this.value), parseFloat(this.value));

    tam= parseFloat(this.value);
});

/***** Evento que permite aparecer las opciones de atributos y realizar cambios en los elementos **/
paper2.on('cell:pointerdown', function(cellView,evt, x, y) { 
  
     selected2 = cellView.model;
     console.log(selected2);
    document.getElementById("draggable").style.display = "inline";

 
});

var anchNueva;
var anchura;
var altura;
var altNueva;
var bandera = 0;
var bandera2= 0;
$wh.on('input change', function() {
  anchNueva= parseFloat(this.value);
  bandera=1;

  if(bandera2==1){

      if (selected2.attributes.type == 'erd.Normal'){

      selected2.resize(parseFloat(this.value), altNueva);

    }else if(selected2.attributes.type == 'basic.Rect'){

      
      selected2.resize(parseFloat(this.value), altNueva);

   }else if(selected2.attributes.type == 'basic.Text'){

      var altura= parseFloat(selected2.attributes.size.height);

      selected2.resize(anchura, altura);
      
   }else{

    selected2.resize(parseFloat(this.value), altNueva);
   }

}else{
  if (selected2.attributes.type == 'erd.Normal'){

      selected2.resize(parseFloat(this.value), 70);

    }else if(selected2.attributes.type == 'basic.Rect'){

      
      selected2.resize(parseFloat(this.value), 98);

   }else if(selected2.attributes.type == 'basic.Text'){

      var altura= parseFloat(selected2.attributes.size.height);

      selected2.resize(parseFloat(this.value), altura);
      
   }else{

    selected2.resize(parseFloat(this.value), 100);
   }
   
}
});

$hg.on('input change', function() {
  bandera2=1;
  altNueva= parseFloat(this.value);
  if (bandera==1){
    if (selected2.attributes.type == 'erd.Normal'){

        selected2.resize(anchNueva, parseFloat(this.value));

      }else if(selected2.attributes.type == 'basic.Rect'){

        
        selected2.resize(anchNueva, parseFloat(this.value));

     }else if(selected2.attributes.type == 'basic.Text'){

        
        selected2.resize(anchNueva, parseFloat(this.value));

     }else{

      selected2.resize(anchNueva, parseFloat(this.value));
     }

     
  }else{
    if (selected2.attributes.type == 'erd.Normal'){

          selected2.resize(130, parseFloat(this.value));

        }else if(selected2.attributes.type == 'basic.Rect'){

          
          selected2.resize(100, parseFloat(this.value));

       }else if(selected2.attributes.type == 'basic.Text'){

          anchura= parseFloat(selected2.attributes.size.width);
          selected2.resize(anchura, parseFloat(this.value));

       }else{

        selected2.resize(100, parseFloat(this.value));
       }
     
  }
});


$texto.on('input change', function() {

      $('input:text').focus(
        function(){
            $(this).val('');
       });
        selected2.attr('text/text', this.value );
});

$rotar.on('input change', function() {

        var coordinates= selected2.get("position");
        selected2.rotate(parseInt(this.value), coordinates);
});

//Evento  que permite desaparecer el cuadro de atributos
paper2.on('blank:pointerclick ', function(cellView,evt, x, y) { 

    document.getElementById("draggable").style.display = "none";

});
/******************************************************************************************************/

/*****************************Funciones de cada boton del toolbar_container***********************************/

function eliminar(){

    graph2.clear();
    document.getElementById("draggable").style.display = "none";
}




paper2.on('cell:pointerdown', function(cellView,evt, x, y) { 

    
    selected = cellView.model;

     
 });

function eliminarElemento(){

    
    if (selected) selected.remove();
     

}


function guardar(use_caseId) { 

    /*Aqui paso a json los diagramas*/
   
   var jsonDiagrama=  graph2.toJSON();

   var jsonString = JSON.stringify(jsonDiagrama);

    //console.log(jsonString);
   var parameters = {

        'id'             : use_caseId,
        'diagrama'       : jsonString,
                
    };
    //console.log(parameters);

    $.ajax({
      type: 'POST',
      url: projectURL+'/diagrama-de-casos-de-uso/actualizar',
      data: parameters,
      dataType: 'JSON',
      success: function (response) {

             
      
       },

      error: function (err) {
         console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
      }


    });

      // graph2.fromJSON(JSON.parse(jsonString))

}

$(document).ready(function(){

    var use_caseid = $('#ident').attr('name');

    $.ajax({
      url: projectURL+'/diagrama-de-casos-de-uso/obtener/'+use_caseid,
      type:'GET',
      dataType: 'JSON',
      success:function (response) {

        if(!response.error){

               //console.log(response['data']);

          if(response['data'] != 'NULL'){

              var  grafico= JSON.parse(response['data']);
              graph2.fromJSON(grafico);
                   

          }
                    
        }
      },
      error: function(xhr, error) {


      }
  });      

});


var filename;

$('#btn-download').on('click', function(){

    filename = $(this).data('download');
    var arrow = $(".marker-arrowhead");
    arrow.remove();

    var tool = $(".link-tools");
    tool.remove();
  
    var svgDoc = paper2.svg;
    var serializer = new XMLSerializer();
    var svgString = serializer.serializeToString(svgDoc);
    var width= 500;
    render(svgString, width, width, filename); 


});
  var c
  var dataURL
function render(svg, width, height, filename) {

  //document.createElement('canvas')
  c = document.createElement('canvas');
  c.width = width || 1000;
  c.height = height || 1000;
  //document.getElementById('canvas').innerHTML = '';
  //document.getElementById('canvas').appendChild(c);

  canvg(c, svg, { log: true, renderCallback: function (dom) {
       

  dataURL = c.toDataURL('image/png');
  console.log(filename);
  
  link = document.getElementById('btn-download');
  link.href=  dataURL;
  link.download = filename;
  
   // console.log(link);
       
  }});
}


var myUndoManager = new Backbone.UndoManager();
myUndoManager.register(graph2);
myUndoManager.startTracking();

$('#undo-button').on('click', function(){
   //console.log(pila);
   myUndoManager.undo();
  
});

$('#redo-button').on('click', function(){
   //console.log(pila);
   myUndoManager.redo();
  
});

$.Shortcut.on("ctrl + Z", function (e) {
    // e is the jQuery normalized KeyEvent
    myUndoManager.undo();
})

$.Shortcut.on("ctrl + Y", function (e) {
    // e is the jQuery normalized KeyEvent
    myUndoManager.redo();
})

var elemento;
graph2.on('add', function(cell) { 
     
    $.Shortcut.on("ctrl + C", function (e) {
    // e is the jQuery normalized KeyEvent
    console.log('New cell with id ' + cell.id + ' added to the graph.') ;
    elemento= cell.clone();
    })

    $.Shortcut.on("ctrl + V", function (e) {
    // e is the jQuery normalized KeyEvent
    graph2.addCell(elemento);
    })



});




/*cambiar titulo del diagrama*/

 $(document).on('click', '.edit-use-info', function(e){

      $('.edit-use-info-save').removeClass('hidden');
      $('.edit-use-info-default').addClass('hidden');

       var useId = $(this).data('use'); 
       
      

      $.ajax({
          url: projectURL+'/diagrama-de-casos-de-uso/obtener-uso-informacion/'+useId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var htmlTitle = '<input type="text" value="'+response.data.title+'" name="values[title]" class="question-title-'+useId+' use-input-name use-input form-control">'
                $('.question-title-'+useId).replaceWith(htmlTitle);


                

              }
          },
          error: function(xhr, error) {

          }
      });     
})

$(document).on('click', '.cancel-edit-question-info', function(e){


       var useId = $(this).data('use'); 
       //console.log(useId);

       $.ajax({
          url: projectURL+'/diagrama-de-casos-de-uso/obtener-uso-informacion/'+useId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var htmlTitle = '<div class="question-title-'+useId+' "><span class="fc-blue-i use-label-value">'+response.data.title+'</span></div>';
                $('.question-title-'+useId).replaceWith(htmlTitle);

                 $('.edit-use-info-save').addClass('hidden');
                 $('.edit-use-info-default').removeClass('hidden');

              }
          },
          error: function(xhr, error) {

          }
      });      

    })
 
    // alde
     $(document).on('click', '.save-edit-use-info', function(e){

       var useId = $(this).data('use'); 

       if($('input[name="values[title]"]').val()==''){

            $('html, body').animate({ scrollTop: 0 }, 'slow');

            if($('input[name="values[title]"]').val()==''){
              $('input[name="values[title]"]').addClass('error-use-input');
            }                                  
            
            $('.error-alert-text').html(' Debe especificar un título para el campo indicado').parent().removeClass('hidden');


       }else{

            var parameters = {
                'values[id]'    : useId,
                'values[title]'       : $('input[name="values[title]"]').val(),
                
            };


           $.ajax({
              url: projectURL+'/diagrama-de-casos-de-uso/actualizar/nombre/'+useId,
              type:'POST',
              dataType: 'JSON',
              data: parameters,
              success:function (response) {

                  if(!response.error){

                    

                    var htmlTitle = '<div class="question-title-'+useId+' titulo-use"><span class="fc-blue-i use-label-value">'+response.data.title+'</span></div>';
                    $('.question-title-'+useId).replaceWith(htmlTitle);

                  
                    $('.edit-use-info-save').addClass('hidden');
                    $('.edit-use-info-default').removeClass('hidden');


                  }
              },
              error: function(xhr, error) {

              }
          });   

      }   

    })   

