
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
    width: 650,
    height: 650,
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
                width: 600,
                height: 600,
                stroke: '#00000',
                fill: '#FFFFFF',


                
            },
            text: {
                text: "Uso",
                fill: "black",
                "font-size": 10,
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
              "font-size": 10,
               

            }
          }

                //content: "<p style='color:black;'>asdf asdf asdf asdf this needs to word wrap</p>"

});



/*Se agregan las imagenes en el stencil*/
graph.addCell(image)
graph.addCell(rect)
graph.addCell(elipse)
graph.addCell(textos)

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

    };

    
})

/*Se agrega una clase a los elementos del contenedor*/
paper.$el.addClass('cursor');


// cache important html elements
var $sx = $('#sx');
var $wh = $('#wh');
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
     //console.log(selected2);
    document.getElementById("draggable").style.display = "inline";

 
});


$wh.on('input change', function() {

     if (selected2.attributes.type == 'erd.Normal'){

     selected2.resize(parseFloat(this.value), 70);
   }else{

    selected2.resize(parseFloat(this.value), parseFloat(this.value));
   }

});

$texto.on('input change', function() {

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


function render(svg, width, height, filename) {

  //document.createElement('canvas')
  var c = document.createElement('canvas');
  c.width = width || 1000;
  c.height = height || 1000;
  //document.getElementById('canvas').innerHTML = '';
  //document.getElementById('canvas').appendChild(c);

  canvg(c, svg, { log: true, renderCallback: function (dom) {
       

  var dataURL = c.toDataURL('image/png');
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


